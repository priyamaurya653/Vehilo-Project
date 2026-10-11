<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    private const MANAGER_ROLES    = ['admin', 'superadmin', 'super_admin', 'super-admin'];
    private const SUPERADMIN_ROLES = ['superadmin', 'super_admin', 'super-admin'];

    /* Images Cloudinary par (set na ho to local public disk) */
    public function __construct(private CloudinaryService $cloud)
    {
    }


    /*
    |--------------------------------------------------------------------------
    | Access helpers
    | admin (partner)  -> sirf apni gaadiyan
    | superadmin       -> sab gaadiyan
    |--------------------------------------------------------------------------
    */

    private function role(Request $request): string
    {
        return strtolower(trim((string) optional($request->user())->role));
    }

    private function isSuperAdmin(Request $request): bool
    {
        return in_array($this->role($request), self::SUPERADMIN_ROLES, true);
    }

    private function denyIfNotManager(Request $request): ?JsonResponse
    {
        if (! in_array($this->role($request), self::MANAGER_ROLES, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Only partners can manage vehicles.',
            ], 403);
        }

        return null;
    }

    private function scoped(Request $request): Builder
    {
        $query = Vehicle::query()->with(['vehicleType', 'partner']);

        if (! $this->isSuperAdmin($request)) {
            $query->where('partner_id', $request->user()->id);
        }

        return $query;
    }

    private function findScoped(Request $request, int $id): ?Vehicle
    {
        return $this->scoped($request)->find($id);
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Vehicle not found.',
        ], 404);
    }


    /*
    |--------------------------------------------------------------------------
    | Input saaf karo (validation se pehle)
    |--------------------------------------------------------------------------
    */

    private function prepare(Request $request): void
    {
        $merge = [];

        // RJ 14 AB 1234 -> RJ14AB1234
        if ($request->filled('vehicle_number')) {
            $merge['vehicle_number'] = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $request->vehicle_number));
        }

        // features: array / "AC, GPS" / JSON string
        if ($request->has('features')) {
            $features = $request->input('features');

            if (is_string($features)) {
                $decoded  = json_decode($features, true);
                $features = is_array($decoded) ? $decoded : explode(',', $features);
            }

            $clean = [];
            foreach ((array) $features as $f) {
                $f = trim((string) $f);
                if ($f !== '' && ! in_array($f, $clean, true)) {
                    $clean[] = $f;
                }
            }
            $merge['features'] = $clean;
        }

        if ($merge) {
            $request->merge($merge);
        }
    }


    private function rules(Request $request, ?Vehicle $vehicle = null): array
    {
        $isCreate = $vehicle === null;

        // Naye type ko active hona chahiye; purana (ab inactive) type rakha ja sakta hai
        $typeRule = Rule::exists('vehicle_types', 'id');
        if ($isCreate || (int) $request->input('vehicle_type_id') !== (int) $vehicle->vehicle_type_id) {
            $typeRule = $typeRule->where('status', true);
        }

        $imageRule = ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'];
        $maxYear   = (int) date('Y') + 1;

        return [
            'vehicle_type_id'    => ['required', 'integer', $typeRule],

            'vehicle_name'       => ['required', 'string', 'max:100'],
            'vehicle_number'     => ['required', 'string', 'min:6', 'max:15', 'regex:/^[A-Z0-9]+$/', Rule::unique('vehicles', 'vehicle_number')->ignore(optional($vehicle)->id)],
            'brand'              => ['required', 'string', 'max:60'],
            'model'              => ['required', 'string', 'max:60'],
            'manufacturing_year' => ['nullable', 'integer', 'between:1990,' . $maxYear],
            'color'              => ['nullable', 'string', 'max:30'],

            'vehicle_image_1'    => array_merge([$isCreate ? 'required' : 'nullable'], $imageRule),
            'vehicle_image_2'    => array_merge(['nullable'], $imageRule),
            'vehicle_image_3'    => array_merge(['nullable'], $imageRule),
            'vehicle_image_4'    => array_merge(['nullable'], $imageRule),
            'remove_images'      => ['nullable', 'array'],
            'remove_images.*'    => ['integer', 'in:2,3,4'],

            'transmission'       => ['required', Rule::in(Vehicle::TRANSMISSIONS)],
            'fuel_type'          => ['required', Rule::in(Vehicle::FUEL_TYPES)],
            'seating_capacity'   => ['required', 'integer', 'between:1,60'],
            'engine_cc'          => ['nullable', 'integer', 'between:0,10000'],
            'mileage'            => ['nullable', 'numeric', 'between:0,1000'],
            'range_per_charge'   => ['nullable', 'integer', 'between:0,2000'],

            'price_per_hour'     => ['nullable', 'numeric', 'between:0,1000000'],
            'price_per_day'      => ['required', 'numeric', 'between:0,1000000'],
            'price_per_week'     => ['nullable', 'numeric', 'between:0,10000000'],
            'security_deposit'   => ['required', 'numeric', 'between:0,1000000'],
            'included_km'        => ['required', 'integer', 'between:0,100000'],
            'extra_km_charge'    => ['required', 'numeric', 'between:0,100000'],

            'country'            => ['required', 'string', 'max:60'],
            'state'              => ['required', 'string', 'max:60'],
            'city'               => ['required', 'string', 'max:60'],
            'location_area'      => ['required', 'string', 'max:100'],
            'pickup_location'    => ['required', 'string', 'max:150'],
            'pincode'            => ['required', 'digits:6'],
            'pickup_address'     => ['required', 'string', 'max:500'],

            'status'             => ['required', Rule::in(Vehicle::STATUSES)],
            'available_from'     => ['nullable', 'date'],
            'available_to'       => ['nullable', 'date', 'after_or_equal:available_from'],
            'minimum_rental_days'=> ['nullable', 'integer', 'between:1,365'],
            'maximum_rental_days'=> ['nullable', 'integer', 'between:1,365'],

            'features'           => ['nullable', 'array', 'max:30'],
            'features.*'         => ['string', 'max:50'],

            'description'        => ['nullable', 'string', 'max:2000'],
        ];
    }

    private function messages(): array
    {
        return [
            'vehicle_type_id.required'   => 'Select a vehicle type.',
            'vehicle_type_id.exists'     => 'Select an active vehicle type.',
            'vehicle_number.unique'      => 'This vehicle number is already registered.',
            'vehicle_number.regex'       => 'Use only letters and numbers, e.g. RJ14AB1234.',
            'vehicle_number.min'         => 'Enter the full vehicle number, e.g. RJ14AB1234.',
            'vehicle_image_1.required'   => 'Upload at least the first vehicle image.',
            'vehicle_image_1.max'        => 'Each image must be 3 MB or smaller.',
            'vehicle_image_2.max'        => 'Each image must be 3 MB or smaller.',
            'vehicle_image_3.max'        => 'Each image must be 3 MB or smaller.',
            'vehicle_image_4.max'        => 'Each image must be 3 MB or smaller.',
            'available_to.after_or_equal'=> 'End date must be on or after the start date.',
            'pincode.digits'             => 'Pincode must be 6 digits.',
        ];
    }

    private function makeValidator(Request $request, ?Vehicle $vehicle = null)
    {
        $validator = Validator::make($request->all(), $this->rules($request, $vehicle), $this->messages());

        $validator->after(function ($validator) use ($request) {

            // Features selected type ke features me se hi hone chahiye
            $type = VehicleType::find($request->input('vehicle_type_id'));
            if ($type) {
                $allowed = array_map('mb_strtolower', $type->vehicle_features ?? []);
                foreach ((array) $request->input('features', []) as $feature) {
                    if (! in_array(mb_strtolower($feature), $allowed, true)) {
                        $validator->errors()->add('features', "\"{$feature}\" is not a feature of {$type->vehicle_type}.");
                        break;
                    }
                }
            }

            // Max days >= min days
            $min = $request->input('minimum_rental_days');
            $max = $request->input('maximum_rental_days');
            if ($min !== null && $max !== null && (int) $max < (int) $min) {
                $validator->errors()->add('maximum_rental_days', 'Maximum days must be equal to or more than minimum days.');
            }
        });

        return $validator;
    }

    private function validationFailed($validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422);
    }

    /* Validated data se images wale keys hata kar DB fields do */
    private function vehicleFields(array $data): array
    {
        unset(
            $data['vehicle_image_1'], $data['vehicle_image_2'],
            $data['vehicle_image_3'], $data['vehicle_image_4'],
            $data['remove_images']
        );

        $data['features']            = $data['features'] ?? [];
        $data['minimum_rental_days'] = $data['minimum_rental_days'] ?? 1;

        return $data;
    }

    /*
     * Images save / replace / remove.
     * Return: [naya images array, delete karne wali purani files]
     */
    private function handleImages(Request $request, Vehicle $vehicle, array &$stored): array
    {
        $images   = (array) ($vehicle->images ?? []);
        $toDelete = [];

        foreach ((array) $request->input('remove_images', []) as $slot) {
            if (isset($images[$slot])) {
                $toDelete[] = $images[$slot];
                unset($images[$slot]);
            }
        }

        foreach (Vehicle::IMAGE_SLOTS as $slot) {
            $field = 'vehicle_image_' . $slot;
            if ($request->hasFile($field)) {
                $path = $this->cloud->upload($request->file($field), 'vehicles/' . $vehicle->id);
                $stored[] = $path;

                if (isset($images[$slot])) {
                    $toDelete[] = $images[$slot];
                }
                $images[$slot] = $path;
            }
        }

        ksort($images);

        return [$images, $toDelete];
    }


    /*
    |--------------------------------------------------------------------------
    | LIST
    | GET /api/v1/admin/vehicles?search=&status=&vehicle_type_id=&page=&per_page=
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $search  = trim((string) $request->query('search', ''));
        $status  = (string) $request->query('status', '');
        $typeId  = (int) $request->query('vehicle_type_id', 0);
        $perPage = min(max((int) $request->query('per_page', 10), 5), 100);

        $query = $this->scoped($request);

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('vehicle_name', 'like', $like)
                  ->orWhere('vehicle_number', 'like', $like)
                  ->orWhere('brand', 'like', $like)
                  ->orWhere('model', 'like', $like)
                  ->orWhere('city', 'like', $like);
            });
        }

        if (in_array($status, Vehicle::STATUSES, true)) {
            $query->where('status', $status);
        }

        if ($typeId > 0) {
            $query->where('vehicle_type_id', $typeId);
        }

        $vehicles = $query->latest()->paginate($perPage);

        $countBase = $this->isSuperAdmin($request)
            ? Vehicle::query()
            : Vehicle::query()->where('partner_id', $request->user()->id);

        return response()->json([
            'success' => true,

            'data' => $vehicles->getCollection()
                ->map(fn (Vehicle $v) => $v->toApiArray())
                ->values(),

            'meta' => [
                'current_page' => $vehicles->currentPage(),
                'last_page'    => $vehicles->lastPage(),
                'per_page'     => $vehicles->perPage(),
                'total'        => $vehicles->total(),
                'from'         => $vehicles->firstItem(),
                'to'           => $vehicles->lastItem(),
            ],

            'counts' => [
                'total'       => (clone $countBase)->count(),
                'available'   => (clone $countBase)->where('status', 'available')->count(),
                'maintenance' => (clone $countBase)->where('status', 'maintenance')->count(),
                'inactive'    => (clone $countBase)->where('status', 'inactive')->count(),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE (multipart/form-data)
    | POST /api/v1/admin/vehicles
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $this->prepare($request);

        $validator = $this->makeValidator($request);

        if ($validator->fails()) {
            return $this->validationFailed($validator);
        }

        $fields = $this->vehicleFields($validator->validated());
        $stored = [];

        try {
            $vehicle = DB::transaction(function () use ($request, $fields, &$stored) {

                $vehicle = Vehicle::create($fields + ['partner_id' => $request->user()->id]);

                [$images] = $this->handleImages($request, $vehicle, $stored);
                $vehicle->update(['images' => $images]);

                return $vehicle;
            });
        } catch (\Throwable $e) {
            foreach ($stored as $path) {
                $this->cloud->delete($path);
            }
            report($e);

            return response()->json([
                'success' => false,
                'message' => config('app.debug') ? 'Vehicle could not be saved: ' . $e->getMessage() : 'Vehicle could not be saved. Please try again.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vehicle added.',
            'data'    => $vehicle->load(['vehicleType', 'partner'])->toApiArray(),
        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW
    | GET /api/v1/admin/vehicles/{id}
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $vehicle = $this->findScoped($request, $id);

        if (! $vehicle) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'data'    => $vehicle->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    | POST /api/v1/admin/vehicles/{id}        (multipart, images ke saath)
    | PUT/PATCH /api/v1/admin/vehicles/{id}   (JSON, bina images)
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $vehicle = $this->findScoped($request, $id);

        if (! $vehicle) {
            return $this->notFound();
        }

        $this->prepare($request);

        $validator = $this->makeValidator($request, $vehicle);

        if ($validator->fails()) {
            return $this->validationFailed($validator);
        }

        $fields   = $this->vehicleFields($validator->validated());
        $stored   = [];
        $toDelete = [];

        try {
            DB::transaction(function () use ($request, $vehicle, $fields, &$stored, &$toDelete) {
                [$images, $toDelete] = $this->handleImages($request, $vehicle, $stored);
                $vehicle->update($fields + ['images' => $images]);
            });
        } catch (\Throwable $e) {
            foreach ($stored as $path) {
                $this->cloud->delete($path);
            }
            report($e);

            return response()->json([
                'success' => false,
                'message' => config('app.debug') ? 'Vehicle could not be updated: ' . $e->getMessage() : 'Vehicle could not be updated. Please try again.',
            ], 500);
        }

        // Purani images save hone ke baad hi hatao
        foreach ($toDelete as $path) {
            $this->cloud->delete($path);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated.',
            'data'    => $vehicle->fresh(['vehicleType', 'partner'])->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS (available / inactive / maintenance)
    | PATCH /api/v1/admin/vehicles/{id}/status    { "status": "maintenance" }
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $vehicle = $this->findScoped($request, $id);

        if (! $vehicle) {
            return $this->notFound();
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(Vehicle::STATUSES)],
        ]);

        if ($validator->fails()) {
            return $this->validationFailed($validator);
        }

        $vehicle->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status changed to ' . $request->status . '.',
            'data'    => $vehicle->toApiArray(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    | DELETE /api/v1/admin/vehicles/{id}
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($deny = $this->denyIfNotManager($request)) {
            return $deny;
        }

        $vehicle = $this->findScoped($request, $id);

        if (! $vehicle) {
            return $this->notFound();
        }

        $images = (array) ($vehicle->images ?? []);

        $vehicle->delete();

        foreach ($images as $path) {
            $this->cloud->delete($path);
        }
        Storage::disk(Vehicle::DISK)->deleteDirectory('vehicles/' . $id);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLIC: riders ke liye available gaadiyan (bina token)
    | GET /api/v1/vehicles?city=&vehicle_type_id=&fuel_type=&transmission=&page=
    | GET /api/v1/vehicles/{id}
    |--------------------------------------------------------------------------
    */

    /*
     * $all = false -> sirf bookable gaadiyan (Available + active type + date valid)
     * $all = true  -> saari registered gaadiyan (home page showcase ke liye)
     */
    private function publicQuery(bool $all = false): Builder
    {
        $query = Vehicle::query()->with('vehicleType');

        if (! $all) {
            $query->where('status', 'available')
                ->whereHas('vehicleType', fn ($q) => $q->where('status', true))
                ->where(fn ($q) => $q->whereNull('available_to')->orWhereDate('available_to', '>=', now()->toDateString()));
        }

        return $query;
    }

    public function publicIndex(Request $request): JsonResponse
    {
        // ?show_all=1 -> Inactive / Maintenance gaadiyan bhi (available pehle)
        $showAll = $request->boolean('show_all');
        $query   = $this->publicQuery($showAll);

        if ($request->filled('city')) {
            // city_exact=1 -> sirf wahi city (filter chips), warna milta-julta naam (search)
            $request->boolean('city_exact')
                ? $query->where('city', trim($request->city))
                : $query->where('city', 'like', '%' . trim($request->city) . '%');
        }
        if ((int) $request->query('vehicle_type_id') > 0) {
            $query->where('vehicle_type_id', (int) $request->query('vehicle_type_id'));
        }
        if (in_array($request->query('fuel_type'), Vehicle::FUEL_TYPES, true)) {
            $query->where('fuel_type', $request->query('fuel_type'));
        }
        if (in_array($request->query('transmission'), Vehicle::TRANSMISSIONS, true)) {
            $query->where('transmission', $request->query('transmission'));
        }

        if ($showAll) {
            $query->orderByRaw("CASE WHEN status = 'available' THEN 0 ELSE 1 END");
        }

        // sort=latest -> naye pehle (home page), default -> sasta pehle
        if ($request->query('sort') === 'latest') {
            $query->latest();
        } else {
            $query->orderBy('price_per_day');
        }

        $perPage  = min(max((int) $request->query('per_page', 12), 1), 50);
        $vehicles = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $vehicles->getCollection()->map(fn (Vehicle $v) => $v->toPublicArray())->values(),
            'meta'    => [
                'current_page' => $vehicles->currentPage(),
                'last_page'    => $vehicles->lastPage(),
                'per_page'     => $vehicles->perPage(),
                'total'        => $vehicles->total(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC: city-wise count (home page city filter)
    | GET /api/v1/vehicles/cities            -> saari registered gaadiyon ki cities
    | GET /api/v1/vehicles/cities?available=1 -> sirf bookable
    |--------------------------------------------------------------------------
    */
    public function publicCities(Request $request): JsonResponse
    {
        $cities = $this->publicQuery(! $request->boolean('available'))
            ->without('vehicleType')
            ->reorder()
            ->select('city', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderByDesc('total')
            ->orderBy('city')
            ->get()
            ->map(fn ($row) => ['city' => $row->city, 'total' => (int) $row->total])
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $cities,
            'total'   => $cities->sum('total'),
        ]);
    }

    public function publicShow(int $id): JsonResponse
    {
        // Detail page har registered gaadi ka khule; book ho sakti hai ya nahi -> is_available
        $vehicle = $this->publicQuery(true)->find($id);

        if (! $vehicle) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'data'    => $vehicle->toPublicArray(),
        ]);
    }
}