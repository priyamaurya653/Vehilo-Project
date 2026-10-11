<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminRiderController extends Controller
{
    private const DISK = 'local';
    private const SUPERADMIN_ROLES = ['superadmin', 'super_admin', 'super-admin'];


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function denyIfNotSuperAdmin(Request $request): ?JsonResponse
    {
        $role = strtolower(trim((string) optional($request->user())->role));

        if (! in_array($role, self::SUPERADMIN_ROLES, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Only super admin can manage riders.',
            ], 403);
        }

        return null;
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Rider not found.',
        ], 404);
    }

    private function findRider(int $id): ?Rider
    {
        return Rider::with('user')->find($id);
    }


    /*
    |--------------------------------------------------------------------------
    | LIST + SEARCH + FILTER
    | GET /api/v1/superadmin/riders?search=&status=&kyc_status=&page=&per_page=
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $search    = trim((string) $request->query('search', ''));
        $status    = (string) $request->query('status', '');
        $kycStatus = (string) $request->query('kyc_status', '');
        $perPage   = min(max((int) $request->query('per_page', 10), 5), 50);

        $query = Rider::query()->with('user');

        if ($search !== '') {
            $like = '%' . $search . '%';

            $query->where(function ($q) use ($like) {
                $q->where('full_name', 'like', $like)
                  ->orWhere('email', 'like', $like)
                  ->orWhere('mobile', 'like', $like)
                  ->orWhere('city', 'like', $like);
            });
        }

        if (in_array($status, Rider::STATUSES, true)) {
            $query->where('status', $status);
        }

        if (in_array($kycStatus, Rider::KYC_STATUSES, true)) {
            $query->where('kyc_status', $kycStatus);
        }

        $riders = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,

            'data' => $riders->getCollection()
                ->map(fn (Rider $rider) => $rider->toApiArray())
                ->values(),

            'meta' => [
                'current_page' => $riders->currentPage(),
                'last_page'    => $riders->lastPage(),
                'per_page'     => $riders->perPage(),
                'total'        => $riders->total(),
                'from'         => $riders->firstItem(),
                'to'           => $riders->lastItem(),
            ],

            'counts' => [
                'total'        => Rider::count(),
                'pending'      => Rider::where('status', 'pending')->count(),
                'active'       => Rider::where('status', 'active')->count(),
                'kyc_verified' => Rider::where('kyc_status', 'verified')->count(),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW
    | GET /api/v1/superadmin/riders/{id}
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $rider = $this->findRider($id);

        if (! $rider) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'data'    => $rider->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    | PUT /api/v1/superadmin/riders/{id}
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $rider = $this->findRider($id);

        if (! $rider) {
            return $this->notFound();
        }

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],

            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('riders', 'email')->ignore($rider->id),
                Rule::unique('users', 'email')->ignore($rider->user_id),
            ],

            'mobile' => [
                'required', 'digits:10',
                Rule::unique('riders', 'mobile')->ignore($rider->id),
                Rule::unique('users', 'mobile')->ignore($rider->user_id),
            ],

            'alternate_mobile'       => ['nullable', 'digits:10', 'different:mobile'],
            'gender'                 => ['nullable', Rule::in(['male', 'female', 'other'])],
            'city'                   => ['required', 'string', 'max:100'],
            'pincode'                => ['nullable', 'digits:6'],
            'address'                => ['nullable', 'string', 'max:500'],
            'date_of_birth'          => ['nullable', 'date'],
            'driving_license_number' => ['nullable', 'string', 'max:30'],

            'kyc_status' => ['required', Rule::in(Rider::KYC_STATUSES)],
            'status'     => ['required', Rule::in(Rider::STATUSES)],
        ], [
            'email.unique'  => 'This email is used by another account.',
            'mobile.unique' => 'This mobile number is used by another account.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        DB::transaction(function () use ($rider, $data) {

            // Pehli baar active hua to approved_at set karo
            if ($data['status'] === 'active' && ! $rider->approved_at) {
                $data['approved_at'] = now();
            }

            $rider->update($data);

            // Login account sync
            if ($rider->user) {
                $canLogin = in_array($data['status'], ['pending', 'active'], true);

                $rider->user->update([
                    'name'   => $data['full_name'],
                    'email'  => $data['email'],
                    'mobile' => $data['mobile'],
                    'status' => $canLogin,
                ]);

                // Inactive / rejected -> sab devices se logout
                if (! $canLogin) {
                    $rider->user->tokens()->delete();
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Rider updated successfully.',
            'data'    => $this->findRider($rider->id)->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE (rider + login account + documents, permanently)
    | DELETE /api/v1/superadmin/riders/{id}
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $rider = $this->findRider($id);

        if (! $rider) {
            return $this->notFound();
        }

        DB::transaction(function () use ($rider) {
            if ($rider->user) {
                $rider->user->tokens()->delete();
                $rider->user->delete();
            }

            $rider->forceDelete();
        });

        Storage::disk(self::DISK)->deleteDirectory('riders/' . $id);

        return response()->json([
            'success' => true,
            'message' => 'Rider deleted.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT (file, token se hi milega)
    | GET /api/v1/superadmin/riders/{id}/documents/{type}
    | type = government_id | address_proof | passport_photo
    |--------------------------------------------------------------------------
    */

    public function document(Request $request, int $id, string $type): Response
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $rider = Rider::find($id);

        if (! $rider) {
            return $this->notFound();
        }

        $path = $rider->getRawOriginal($type);

        if (! $path || ! Storage::disk(self::DISK)->exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'Document not uploaded.',
            ], 404);
        }

        return Storage::disk(self::DISK)->response($path);
    }
}