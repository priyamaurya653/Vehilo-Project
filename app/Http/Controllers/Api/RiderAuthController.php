<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RiderAuthController extends Controller
{
    /* Documents private disk par save hote hain (public URL nahi banta) */
    private const DISK = 'local';

    private const OTP_TTL_MINUTES      = 10;
    private const VERIFIED_TTL_MINUTES = 30;
    private const OTP_MAX_ATTEMPTS     = 5;


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function otpKey(string $mobile): string
    {
        return 'rider_otp:' . $mobile;
    }

    private function verifiedKey(string $mobile): string
    {
        return 'rider_otp_verified:' . $mobile;
    }

    private function fail(string $message, array $errors = [], int $status = 422): JsonResponse
    {
        return response()->json(array_filter([
            'success' => false,
            'message' => $message,
            'errors'  => $errors ?: null,
        ], fn ($v) => $v !== null), $status);
    }

    /*
     * SMS bhejne ki jagah.
     * Apna SMS provider (MSG91, Twilio, Fast2SMS...) yahan lagao.
     */
    private function sendSms(string $mobile, string $otp): void
    {
        Log::info("Rider OTP for {$mobile}: {$otp}");
    }


    /*
    |--------------------------------------------------------------------------
    | 1) SEND OTP
    | POST /api/v1/rider/send-otp     { "mobile": "9876543210" }
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'digits:10'],
        ], [
            'mobile.digits' => 'Enter a valid 10 digit mobile number.',
        ]);

        if ($validator->fails()) {
            return $this->fail('Validation failed.', $validator->errors()->toArray());
        }

        $mobile = $request->mobile;

        $alreadyRegistered = Rider::withTrashed()->where('mobile', $mobile)->exists()
            || User::where('mobile', $mobile)->exists();

        if ($alreadyRegistered) {
            return $this->fail('Validation failed.', [
                'mobile' => ['This mobile number is already registered. Log in instead.'],
            ]);
        }

        $otp = (string) random_int(100000, 999999);

        Cache::put($this->otpKey($mobile), [
            'hash'     => Hash::make($otp),
            'attempts' => 0,
        ], now()->addMinutes(self::OTP_TTL_MINUTES));

        Cache::forget($this->verifiedKey($mobile));

        $this->sendSms($mobile, $otp);

        $response = [
            'success'    => true,
            'message'    => 'OTP sent to your mobile number.',
            'expires_in' => self::OTP_TTL_MINUTES * 60,
        ];

        // Sirf local testing ke liye OTP response me (production me kabhi nahi)
        if (app()->environment('local')) {
            $response['debug_otp'] = $otp;
        }

        return response()->json($response);
    }


    /*
    |--------------------------------------------------------------------------
    | 2) VERIFY OTP
    | POST /api/v1/rider/verify-otp   { "mobile": "9876543210", "otp": "123456" }
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'digits:10'],
            'otp'    => ['required', 'digits:6'],
        ], [
            'otp.digits' => 'Enter the 6 digit OTP.',
        ]);

        if ($validator->fails()) {
            return $this->fail('Validation failed.', $validator->errors()->toArray());
        }

        $mobile = $request->mobile;
        $data   = Cache::get($this->otpKey($mobile));

        if (! $data) {
            return $this->fail('Validation failed.', ['otp' => ['OTP expired. Request a new one.']]);
        }

        if ($data['attempts'] >= self::OTP_MAX_ATTEMPTS) {
            Cache::forget($this->otpKey($mobile));

            return $this->fail('Validation failed.', ['otp' => ['Too many wrong attempts. Request a new OTP.']]);
        }

        if (! Hash::check($request->otp, $data['hash'])) {
            $data['attempts']++;
            Cache::put($this->otpKey($mobile), $data, now()->addMinutes(self::OTP_TTL_MINUTES));

            return $this->fail('Validation failed.', ['otp' => ['Incorrect OTP. Check the code and try again.']]);
        }

        Cache::forget($this->otpKey($mobile));
        Cache::put($this->verifiedKey($mobile), true, now()->addMinutes(self::VERIFIED_TTL_MINUTES));

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 3) REGISTER (multipart/form-data)
    | POST /api/v1/rider/register
    |--------------------------------------------------------------------------
    */

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name'              => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'email', 'max:255', 'unique:users,email', 'unique:riders,email'],
            'mobile'                 => ['required', 'digits:10', 'unique:users,mobile', 'unique:riders,mobile'],
            'password'               => ['required', 'string', 'min:8', 'confirmed'],

            'alternate_mobile'       => ['nullable', 'digits:10', 'different:mobile'],
            'gender'                 => ['nullable', 'in:male,female,other'],
            'city'                   => ['required', 'string', 'max:100'],
            'pincode'                => ['nullable', 'digits:6'],
            'address'                => ['nullable', 'string', 'max:500'],

            'aadhaar'                => ['required', 'digits:12', 'unique:riders,aadhaar'],
            'date_of_birth'          => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->toDateString()],
            'driving_license_number' => ['nullable', 'string', 'max:30'],

            'government_id'          => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'address_proof'          => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'passport_photo'         => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'email.unique'                  => 'This email is already registered.',
            'mobile.unique'                 => 'This mobile number is already registered.',
            'mobile.digits'                 => 'Enter a valid 10 digit mobile number.',
            'aadhaar.digits'                => 'Aadhaar number must be 12 digits.',
            'aadhaar.unique'                => 'This Aadhaar number is already registered.',
            'date_of_birth.before_or_equal' => 'You must be at least 18 years old.',
            'government_id.max'             => 'Government ID must be 5 MB or smaller.',
            'address_proof.max'             => 'Address proof must be 5 MB or smaller.',
            'passport_photo.max'            => 'Photo must be 2 MB or smaller.',
        ]);

        if ($validator->fails()) {
            return $this->fail('Validation failed.', $validator->errors()->toArray());
        }

        // Mobile OTP verify hua hai ya nahi
        if (! Cache::get($this->verifiedKey($request->mobile))) {
            return $this->fail('Validation failed.', [
                'otp' => ['Verify your mobile number with OTP first.'],
            ]);
        }

        $data   = $validator->validated();
        $stored = [];

        try {
            $rider = DB::transaction(function () use ($request, $data, &$stored) {

                // Login account
                $user = User::create([
                    'name'     => $data['full_name'],
                    'email'    => $data['email'],
                    'mobile'   => $data['mobile'],
                    'password' => Hash::make($data['password']),
                    'role'     => 'user',
                    'status'   => true,
                ]);

                // Rider profile
                $rider = Rider::create([
                    'user_id'                => $user->id,
                    'full_name'              => $data['full_name'],
                    'email'                  => $data['email'],
                    'mobile'                 => $data['mobile'],
                    'alternate_mobile'       => $data['alternate_mobile'] ?? null,
                    'gender'                 => $data['gender'] ?? null,
                    'city'                   => $data['city'],
                    'pincode'                => $data['pincode'] ?? null,
                    'address'                => $data['address'] ?? null,
                    'aadhaar'                => $data['aadhaar'],
                    'date_of_birth'          => $data['date_of_birth'],
                    'driving_license_number' => $data['driving_license_number'] ?? null,
                    'otp_verified_at'        => now(),
                    'kyc_status'             => 'pending',
                    'status'                 => 'pending',
                ]);

                // Documents: storage/app/riders/{id}/...
                $paths = [];
                foreach (Rider::DOCUMENT_TYPES as $field) {
                    if ($request->hasFile($field)) {
                        $path = $request->file($field)->store('riders/' . $rider->id, self::DISK);
                        $stored[] = $path;
                        $paths[$field] = $path;
                    }
                }

                $rider->update($paths);

                return $rider;
            });

        } catch (\Throwable $e) {
            foreach ($stored as $path) {
                Storage::disk(self::DISK)->delete($path);
            }

            report($e);

            // APP_DEBUG=true ho to asli wajah dikhao (production me generic message)
            return $this->fail(
                config('app.debug')
                    ? 'Registration failed: ' . $e->getMessage()
                    : 'Registration failed. Please try again.',
                [],
                500
            );
        }

        Cache::forget($this->verifiedKey($request->mobile));

        return response()->json([
            'success'   => true,
            'message'   => 'Registration successful. Log in to track your verification.',
            'data'      => $rider->load('user')->toApiArray(),
            'login_url' => url('/login'),
        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | 4) LOGGED-IN RIDER PROFILE
    | GET /api/v1/rider/me   (Bearer token)
    |--------------------------------------------------------------------------
    */

    public function me(Request $request): JsonResponse
    {
        $rider = Rider::with('user')
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $rider) {
            return $this->fail('No rider profile found for this account.', [], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $rider->toApiArray(),
        ]);
    }
}