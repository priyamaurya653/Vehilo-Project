<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Services\CloudinaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleTypeController extends Controller
{
    /* Kaun vehicle types manage kar sakta hai */
    private const MANAGER_ROLES = ['admin', 'superadmin', 'super_admin', 'super-admin'];

    /* Icon Cloudinary par (set na ho to local public disk) */
    public function __construct(private CloudinaryService $cloud)
    {
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function denyIfNotManager(Request $request): ?JsonResponse
    {
        $role = strtolower(trim((string) optional($request->user())->role));

        if (! in_array($role, self::MANAGER_ROLES, true)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to manage vehicle types.',
            ], 403);
        }

        return null;
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Vehicle type not found.',
        ], 404);
    }

    /*
     * vehicle_features 3 tarah se aa sakta hai:
     *   ["AC","GPS"]          (JSON array / form array vehicle_features[])
     *   "AC, GPS, Bluetooth"  (comma string)
     *   '["AC","GPS"]'        (JSON string, multipart me)
     * Sabko saaf array bana do (trim, khali hatao, duplicate hatao).
     */
    private function normalizeFeatures(Request $request): void
    {
        if (! $request->has('vehicle_features')) {
            return;
        }

        $features = $request->input('vehicle_features');

        if (is_string($features)) {
            $decoded  = json_decode($features, true);
            $features = is_array($decoded) ? $decoded : explode(',', $features);
        }

        if (! is_array($features)) {
            return;
        }

        $clean = [];
        foreach ($features as $feature) {
            $feature = trim((string) $feature);
            if ($feature !== '' && ! in_array(mb_strtolower($feature), array_map('mb_strtolower', $clean), true)) {
                $clean[] = $feature;
            }
        }

        $request->merge(['vehicle_features' => $clean]);
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'vehicle_type'       => ['required', 'string', 'max:100', Rule::unique('vehicle_types', 'vehicle_type')->ignore($ignoreId)],
            'vehicle_features'   => ['required', 'array', 'min:1', 'max:30'],
            'vehicle_features.*' => ['required', 'string', 'max:50'],
            'description'        => ['nullable', 'string', 'max:1000'],
            'icon'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'remove_icon'        => ['nullable', 'boolean'],
            'status'             => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'vehicle_type.unique'       => 'This vehicle type already exists.',
            'vehicle_features.required' => 'Add at least one feature.',
            'vehicle_features.min'      => 'Add at least one feature.',
            'vehicle_features.max'      => 'You can add up to 30 features.',
            'vehicle_features.*.max'    => 'Each feature can be up to 50 characters.',
            'icon.max'                  => 'Icon must be 1 MB or smaller.',
        ];
    }

    private function validationFailed($validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLIC: sirf active types (app / website dropdown ke liye)
    | GET /api/v1/vehicle-types
    |--------------------------------------------------------------------------
    */

    public function publicIndex(): JsonResponse
    {
        // Home page "Every kind of vehicle" ke liye har type ki gaadiyon ki ginti bhi
        $types = VehicleType::query()
            ->where('status', true)
            ->withCount('vehicles')
            ->orderByDesc('vehicles_count')
            ->orderBy('vehicle_type')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $types->map(fn (VehicleType $t) => $t->toPublicArray())->values(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLIC: ek type ke features (Add Vehicle form ke liye)
    | GET /api/v1/vehicle-features?vehicle_type_id=3
    |--------------------------------------------------------------------------
    */

    public function publicFeatures(Request $request): JsonResponse
    {
        $typeId = (int) $request->query('vehicle_type_id', 0);

        if ($typeId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => ['vehicle_type_id' => ['Select a vehicle type.']],
            ], 422);
        }

        $type = VehicleType::where('status', true)->find($typeId);

        if (! $type) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'vehicle_type_id' => $type->id,
                'vehicle_type'    => $type->vehicle_type,
                'features'        => array_values($type->vehicle_features ?? []),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | LIST
    | GET /api/v1/admin/vehicle-types?search=&status=active|inactive&page=&per_page=
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $search  = trim((string) $request->query('search', ''));
        $status  = (string) $request->query('status', '');
        $perPage = min(max((int) $request->query('per_page', 10), 5), 100);

        $query = VehicleType::query();

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('vehicle_type', 'like', $like)
                  ->orWhere('vehicle_features', 'like', $like)
                  ->orWhere('description', 'like', $like);
            });
        }

        if ($status === 'active') {
            $query->where('status', true);
        } elseif ($status === 'inactive') {
            $query->where('status', false);
        }

        $types = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,

            'data' => $types->getCollection()
                ->map(fn (VehicleType $t) => $t->toApiArray())
                ->values(),

            'meta' => [
                'current_page' => $types->currentPage(),
                'last_page'    => $types->lastPage(),
                'per_page'     => $types->perPage(),
                'total'        => $types->total(),
                'from'         => $types->firstItem(),
                'to'           => $types->lastItem(),
            ],

            'counts' => [
                'total'    => VehicleType::count(),
                'active'   => VehicleType::where('status', true)->count(),
                'inactive' => VehicleType::where('status', false)->count(),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE (JSON ya multipart/form-data, icon ke liye multipart)
    | POST /api/v1/admin/vehicle-types
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $this->normalizeFeatures($request);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return $this->validationFailed($validator);
        }

        $data = $validator->validated();

        try {
            $iconPath = $request->hasFile('icon')
                ? $this->cloud->upload($request->file('icon'), 'vehicle-types')
                : null;
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => ['icon' => [config('app.debug') ? $e->getMessage() : 'Icon could not be uploaded. Try again.']],
            ], 422);
        }

        $type = VehicleType::create([
            'vehicle_type'     => $data['vehicle_type'],
            'vehicle_features' => $data['vehicle_features'],
            'description'      => $data['description'] ?? null,
            'icon'             => $iconPath,
            'status'           => array_key_exists('status', $data) && $data['status'] !== null ? (bool) $data['status'] : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type added.',
            'data'    => $type->toApiArray(),
        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW
    | GET /api/v1/admin/vehicle-types/{id}
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $type = VehicleType::find($id);

        if (! $type) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'data'    => $type->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    | PUT/PATCH /api/v1/admin/vehicle-types/{id}           (JSON)
    | POST      /api/v1/admin/vehicle-types/{id}           (multipart, icon badalna ho to)
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $type = VehicleType::find($id);

        if (! $type) {
            return $this->notFound();
        }

        $this->normalizeFeatures($request);

        $validator = Validator::make($request->all(), $this->rules($type->id), $this->messages());

        if ($validator->fails()) {
            return $this->validationFailed($validator);
        }

        $data    = $validator->validated();
        $oldIcon = $type->icon;
        $newIcon = $oldIcon;

        if ($request->hasFile('icon')) {
            try {
                $newIcon = $this->cloud->upload($request->file('icon'), 'vehicle-types');
            } catch (\Throwable $e) {
                report($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => ['icon' => [config('app.debug') ? $e->getMessage() : 'Icon could not be uploaded. Try again.']],
                ], 422);
            }
        } elseif (! empty($data['remove_icon'])) {
            $newIcon = null;
        }

        $type->update([
            'vehicle_type'     => $data['vehicle_type'],
            'vehicle_features' => $data['vehicle_features'],
            'description'      => $data['description'] ?? null,
            'icon'             => $newIcon,
            'status'           => array_key_exists('status', $data) && $data['status'] !== null ? (bool) $data['status'] : $type->status,
        ]);

        // Purana icon hata do
        if ($oldIcon && $oldIcon !== $newIcon) {
            $this->cloud->delete($oldIcon);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type updated.',
            'data'    => $type->fresh()->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE / INACTIVE
    | PATCH /api/v1/admin/vehicle-types/{id}/toggle
    |--------------------------------------------------------------------------
    */

    public function toggle(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $type = VehicleType::find($id);

        if (! $type) {
            return $this->notFound();
        }

        $type->update(['status' => ! $type->status]);

        return response()->json([
            'success' => true,
            'message' => $type->status ? 'Vehicle type activated.' : 'Vehicle type deactivated.',
            'data'    => $type->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    | DELETE /api/v1/admin/vehicle-types/{id}
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $type = VehicleType::find($id);

        if (! $type) {
            return $this->notFound();
        }

        // Is type ki gaadiyan hain to delete mat karo
        $inUse = Vehicle::where('vehicle_type_id', $type->id)->count();

        if ($inUse > 0) {
            return response()->json([
                'success' => false,
                'message' => "{$inUse} vehicle(s) use this type. Change their type or deactivate this type instead.",
            ], 422);
        }

        $icon = $type->icon;
        $type->delete();

        if ($icon) {
            $this->cloud->delete($icon);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type deleted.',
        ]);
    }
}