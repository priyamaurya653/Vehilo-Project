<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerApplication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuperAdminPartnerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Allowed values (register form ke options se match karte hain)
    |--------------------------------------------------------------------------
    */

    private const SUPERADMIN_ROLES   = ['superadmin', 'super_admin', 'super-admin'];
    private const PARTNERSHIP_TYPES  = ['franchise', 'fleet', 'rental', 'charging', 'delivery'];
    private const INVESTMENTS        = ['under-5', '5-10', '10-25', '25-50', '50-plus'];
    private const SPACES             = ['under-500', '500-1000', '1000-2500', '2500-plus'];
    private const EXPERIENCES        = ['new', '1-3', '3-5', '5-plus'];
    private const FLEET_SIZES        = ['1-5', '6-10', '11-25', '25-plus'];
    private const APPLICATION_STATUS = ['pending', 'approved', 'rejected'];


    /*
    |--------------------------------------------------------------------------
    | Sirf super admin allowed
    |--------------------------------------------------------------------------
    */

    private function denyIfNotSuperAdmin(Request $request): ?JsonResponse
    {
        $role = strtolower(trim((string) optional($request->user())->role));

        if (! in_array($role, self::SUPERADMIN_ROLES, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Only super admin can access partners.',
            ], 403);
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Partner ko ek jaisa JSON format do
    |--------------------------------------------------------------------------
    */

    private function formatPartner(User $user): array
    {
        $app = $user->partnerApplication;

        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'mobile'     => $user->mobile,
            'is_active'  => (bool) $user->status,
            'created_at' => optional($user->created_at)->toIso8601String(),

            'application' => $app ? [
                'id'               => $app->id,
                'partnership_type' => $app->partnership_type,
                'investment'       => $app->investment,
                'property'         => $app->property,
                'space'            => $app->space,
                'experience'       => $app->experience,
                'fleet_size'       => $app->fleet_size,
                'consent'          => (bool) $app->consent,
                'status'           => $app->status,
                'created_at'       => optional($app->created_at)->toIso8601String(),
            ] : null,
        ];
    }


    private function findPartner(int $id): ?User
    {
        return User::query()
            ->where('role', 'admin')
            ->with('partnerApplication')
            ->find($id);
    }


    /*
    |--------------------------------------------------------------------------
    | LIST + SEARCH + FILTER + PAGINATION
    | GET /api/v1/superadmin/partners?search=&partnership_type=&status=&page=&per_page=
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $search  = trim((string) $request->query('search', ''));
        $type    = (string) $request->query('partnership_type', '');
        $status  = (string) $request->query('status', '');
        $perPage = min(max((int) $request->query('per_page', 10), 5), 50);

        $query = User::query()
            ->where('role', 'admin')
            ->with('partnerApplication');

        // Search: name / email / mobile
        if ($search !== '') {
            $like = '%' . $search . '%';

            $query->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                  ->orWhere('email', 'like', $like)
                  ->orWhere('mobile', 'like', $like);
            });
        }

        // Filter: partnership type
        if (in_array($type, self::PARTNERSHIP_TYPES, true)) {
            $query->whereHas('partnerApplication', fn ($q) => $q->where('partnership_type', $type));
        }

        // Filter: application status
        if (in_array($status, self::APPLICATION_STATUS, true)) {
            $query->whereHas('partnerApplication', fn ($q) => $q->where('status', $status));
        }

        $partners = $query->latest()->paginate($perPage);

        // Upar ke stats cards ke liye counts
        $countFor = function (?string $appStatus) {
            $q = User::query()->where('role', 'admin');

            if ($appStatus) {
                $q->whereHas('partnerApplication', fn ($a) => $a->where('status', $appStatus));
            }

            return $q->count();
        };

        return response()->json([
            'success' => true,

            'data' => $partners->getCollection()
                ->map(fn (User $user) => $this->formatPartner($user))
                ->values(),

            'meta' => [
                'current_page' => $partners->currentPage(),
                'last_page'    => $partners->lastPage(),
                'per_page'     => $partners->perPage(),
                'total'        => $partners->total(),
                'from'         => $partners->firstItem(),
                'to'           => $partners->lastItem(),
            ],

            'counts' => [
                'total'    => $countFor(null),
                'approved' => $countFor('approved'),
                'pending'  => $countFor('pending'),
                'rejected' => $countFor('rejected'),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW
    | GET /api/v1/superadmin/partners/{id}
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $partner = $this->findPartner($id);

        if (! $partner) {
            return response()->json([
                'success' => false,
                'message' => 'Partner not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->formatPartner($partner),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT / UPDATE
    | PUT /api/v1/superadmin/partners/{id}
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $partner = $this->findPartner($id);

        if (! $partner) {
            return response()->json([
                'success' => false,
                'message' => 'Partner not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($partner->id)],
            'mobile' => ['required', 'string', 'max:20', Rule::unique('users', 'mobile')->ignore($partner->id)],

            'is_active' => ['required', 'boolean'],

            'partnership_type'   => ['required', Rule::in(self::PARTNERSHIP_TYPES)],
            'investment'         => ['required', Rule::in(self::INVESTMENTS)],
            'property'           => ['required', Rule::in(['yes', 'no'])],
            'space'              => ['required', Rule::in(self::SPACES)],
            'experience'         => ['required', Rule::in(self::EXPERIENCES)],
            'fleet_size'         => ['required', Rule::in(self::FLEET_SIZES)],
            'application_status' => ['required', Rule::in(self::APPLICATION_STATUS)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        DB::transaction(function () use ($partner, $data) {

            // 1) User (login account) update
            $partner->update([
                'name'   => $data['name'],
                'email'  => $data['email'],
                'mobile' => $data['mobile'],
                'status' => (bool) $data['is_active'],
            ]);

            // 2) Application update (na ho to bana do)
            $appData = [
                'name'             => $data['name'],
                'email'            => $data['email'],
                'mobile'           => $data['mobile'],
                'partnership_type' => $data['partnership_type'],
                'investment'       => $data['investment'],
                'property'         => $data['property'],
                'space'            => $data['space'],
                'experience'       => $data['experience'],
                'fleet_size'       => $data['fleet_size'],
                'status'           => $data['application_status'],
            ];

            if ($partner->partnerApplication) {
                $partner->partnerApplication->update($appData);
            } else {
                PartnerApplication::create($appData + [
                    'user_id' => $partner->id,
                    'consent' => true,
                ]);
            }
        });

        $partner = $this->findPartner($partner->id);

        return response()->json([
            'success' => true,
            'message' => 'Partner updated successfully.',
            'data'    => $this->formatPartner($partner),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE / REJECT (partner requests)
    | PATCH /api/v1/superadmin/partners/{id}/status   body: { "status": "approved" }
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotSuperAdmin($request)) {
            return $deny;
        }

        $partner = $this->findPartner($id);

        if (! $partner) {
            return response()->json([
                'success' => false,
                'message' => 'Partner not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(self::APPLICATION_STATUS)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if (! $partner->partnerApplication) {
            return response()->json([
                'success' => false,
                'message' => 'This partner has no application. Use Edit to add the details first.',
            ], 422);
        }

        $status = $validator->validated()['status'];

        $partner->partnerApplication->update(['status' => $status]);

        $messages = [
            'approved' => 'Partner approved.',
            'rejected' => 'Partner rejected.',
            'pending'  => 'Partner moved back to pending.',
        ];

        $partner = $this->findPartner($partner->id);

        return response()->json([
            'success' => true,
            'message' => $messages[$status],
            'data'    => $this->formatPartner($partner),
        ]);
    }
}