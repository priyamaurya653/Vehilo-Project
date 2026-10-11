<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\CloudinaryService;

class Vehicle extends Model
{
    use HasFactory;

    public const DISK          = 'public';
    public const IMAGE_SLOTS   = [1, 2, 3, 4];
    public const STATUSES      = ['available', 'inactive', 'maintenance'];
    public const TRANSMISSIONS = ['manual', 'automatic', 'geared'];
    public const FUEL_TYPES    = ['petrol', 'diesel', 'cng', 'electric', 'hybrid'];

    protected $fillable = [
        'partner_id',
        'vehicle_type_id',

        'vehicle_name',
        'vehicle_number',
        'brand',
        'model',
        'manufacturing_year',
        'color',

        'images',

        'transmission',
        'fuel_type',
        'seating_capacity',
        'engine_cc',
        'mileage',
        'range_per_charge',

        'price_per_hour',
        'price_per_day',
        'price_per_week',
        'security_deposit',
        'included_km',
        'extra_km_charge',

        'country',
        'state',
        'city',
        'location_area',
        'pickup_location',
        'pincode',
        'pickup_address',

        'status',
        'available_from',
        'available_to',
        'minimum_rental_days',
        'maximum_rental_days',

        'features',
        'description',
    ];

    protected $casts = [
        'images'              => 'array',
        'features'            => 'array',
        'available_from'      => 'date',
        'available_to'        => 'date',
        'manufacturing_year'  => 'integer',
        'seating_capacity'    => 'integer',
        'engine_cc'           => 'integer',
        'range_per_charge'    => 'integer',
        'included_km'         => 'integer',
        'minimum_rental_days' => 'integer',
        'maximum_rental_days' => 'integer',
    ];


    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }


    /* [{slot: 1, url: "..."}, ...] */
    public function imageList(): array
    {
        $list = [];
        foreach ((array) $this->images as $slot => $path) {
            if ($path) {
                // Cloudinary URL ho to wahi, purani local image ho to /storage/... URL
                $list[] = ['slot' => (int) $slot, 'url' => CloudinaryService::url($path)];
            }
        }
        usort($list, fn ($a, $b) => $a['slot'] <=> $b['slot']);

        return $list;
    }

    private static function money($value): ?float
    {
        return $value === null ? null : (float) $value;
    }


    /* Partner / superadmin API */
    public function toApiArray(): array
    {
        return [
            'id'              => $this->id,
            'partner_id'      => $this->partner_id,
            'partner_name'    => optional($this->partner)->name,

            'vehicle_type_id' => $this->vehicle_type_id,
            'vehicle_type'    => optional($this->vehicleType)->vehicle_type,

            'vehicle_name'       => $this->vehicle_name,
            'vehicle_number'     => $this->vehicle_number,
            'brand'              => $this->brand,
            'model'              => $this->model,
            'manufacturing_year' => $this->manufacturing_year,
            'color'              => $this->color,

            'images' => $this->imageList(),

            'transmission'     => $this->transmission,
            'fuel_type'        => $this->fuel_type,
            'seating_capacity' => $this->seating_capacity,
            'engine_cc'        => $this->engine_cc,
            'mileage'          => self::money($this->mileage),
            'range_per_charge' => $this->range_per_charge,

            'price_per_hour'   => self::money($this->price_per_hour),
            'price_per_day'    => self::money($this->price_per_day),
            'price_per_week'   => self::money($this->price_per_week),
            'security_deposit' => self::money($this->security_deposit),
            'included_km'      => $this->included_km,
            'extra_km_charge'  => self::money($this->extra_km_charge),

            'country'         => $this->country,
            'state'           => $this->state,
            'city'            => $this->city,
            'location_area'   => $this->location_area,
            'pickup_location' => $this->pickup_location,
            'pincode'         => $this->pincode,
            'pickup_address'  => $this->pickup_address,

            'status'              => $this->status,
            'available_from'      => optional($this->available_from)->format('Y-m-d'),
            'available_to'        => optional($this->available_to)->format('Y-m-d'),
            'minimum_rental_days' => $this->minimum_rental_days,
            'maximum_rental_days' => $this->maximum_rental_days,

            'features'    => array_values($this->features ?? []),
            'description' => $this->description,

            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }


    /* Riders ke liye public API (vehicle number, partner, internal fields nahi) */
    public function toPublicArray(): array
    {
        $data = $this->toApiArray();

        // Rider ko sirf ye pata chale ki abhi book ho sakti hai ya nahi
        $data['is_available'] = $this->status === 'available'
            && (bool) optional($this->vehicleType)->status
            && (! $this->available_to || $this->available_to->endOfDay()->isFuture());

        unset(
            $data['partner_id'],
            $data['partner_name'],
            $data['vehicle_number'],
            $data['status'],
            $data['created_at'],
            $data['updated_at']
        );

        return $data;
    }
}