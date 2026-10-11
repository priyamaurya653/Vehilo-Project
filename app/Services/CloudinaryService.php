<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

/*
|--------------------------------------------------------------------------
| Cloudinary (REST API, bina kisi package ke)
|
| .env:
|   CLOUDINARY_CLOUD_NAME=xxxx
|   CLOUDINARY_API_KEY=xxxx
|   CLOUDINARY_API_SECRET=xxxx
|   CLOUDINARY_FOLDER=wheelo
|   CLOUDINARY_VERIFY_SSL=true     (local Windows par SSL error aaye to false)
|
| Cloudinary set nahi hai to image local public disk par save hoti hai.
|--------------------------------------------------------------------------
*/
class CloudinaryService
{
    private ?string $cloud;
    private ?string $key;
    private ?string $secret;
    private string $baseFolder;
    private bool $verifySsl;

    public function __construct()
    {
        $config = config('services.cloudinary', []);

        $this->cloud      = $config['cloud_name'] ?? null;
        $this->key        = $config['api_key'] ?? null;
        $this->secret     = $config['api_secret'] ?? null;
        $this->baseFolder = trim($config['folder'] ?? 'wheelo', '/');
        $this->verifySsl  = (bool) ($config['verify_ssl'] ?? true);
    }

    public function enabled(): bool
    {
        return $this->cloud && $this->key && $this->secret;
    }


    /*
     * Image upload karo. Return: poora URL (Cloudinary) ya local path.
     * $folder: jaise "vehicles/5"
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        if (! $this->enabled()) {
            return $file->store(trim($folder, '/'), 'public');
        }

        $params = [
            'folder'    => $this->baseFolder . '/' . trim($folder, '/'),
            'timestamp' => time(),
        ];

        $response = Http::withOptions(['verify' => $this->verifySsl])
            ->timeout(60)
            ->attach('file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
            ->post($this->endpoint('upload'), $params + [
                'api_key'   => $this->key,
                'signature' => $this->sign($params),
            ]);

        if (! $response->successful() || ! $response->json('secure_url')) {
            $error = $response->json('error.message') ?: $response->body();
            throw new RuntimeException('Cloudinary upload failed: ' . $error);
        }

        return $response->json('secure_url');
    }


    /* Image hatao: Cloudinary URL ho to Cloudinary se, warna local disk se */
    public function delete(?string $pathOrUrl): void
    {
        if (! $pathOrUrl) {
            return;
        }

        if (! $this->isRemote($pathOrUrl)) {
            Storage::disk('public')->delete($pathOrUrl);
            return;
        }

        $publicId = $this->publicIdFromUrl($pathOrUrl);

        if (! $publicId || ! $this->enabled()) {
            return;
        }

        $params = ['public_id' => $publicId, 'timestamp' => time()];

        try {
            Http::withOptions(['verify' => $this->verifySsl])
                ->timeout(30)
                ->asForm()
                ->post($this->endpoint('destroy'), $params + [
                    'api_key'   => $this->key,
                    'signature' => $this->sign($params),
                ]);
        } catch (\Throwable $e) {
            // Delete fail hone par record delete nahi rukna chahiye
            Log::warning('Cloudinary delete failed: ' . $e->getMessage(), ['public_id' => $publicId]);
        }
    }


    /* DB me save value -> browser me dikhne wala URL */
    public static function url(?string $pathOrUrl): ?string
    {
        if (! $pathOrUrl) {
            return null;
        }

        if (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://')) {
            return $pathOrUrl;
        }

        // Local file: /media/... route se (storage:link / symlink ki zaroorat nahi)
        return url('/media/' . ltrim(str_replace('\\', '/', $pathOrUrl), '/'));
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function isRemote(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }

    private function endpoint(string $action): string
    {
        return "https://api.cloudinary.com/v1_1/{$this->cloud}/image/{$action}";
    }

    /* Cloudinary signature: params alphabet order me, & se jode, secret laga kar sha1 */
    private function sign(array $params): string
    {
        ksort($params);

        $pairs = [];
        foreach ($params as $key => $value) {
            $pairs[] = $key . '=' . $value;
        }

        return sha1(implode('&', $pairs) . $this->secret);
    }

    /*
     * https://res.cloudinary.com/demo/image/upload/v1712345678/wheelo/vehicles/5/abc.jpg
     *  -> wheelo/vehicles/5/abc
     */
    private function publicIdFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $pos  = strpos($path, '/upload/');

        if ($pos === false) {
            return null;
        }

        $rest = substr($path, $pos + strlen('/upload/'));
        $rest = preg_replace('#^v\d+/#', '', $rest);        // version hatao
        $rest = preg_replace('#\.[a-zA-Z0-9]+$#', '', $rest); // extension hatao

        return $rest !== '' ? urldecode($rest) : null;
    }
}