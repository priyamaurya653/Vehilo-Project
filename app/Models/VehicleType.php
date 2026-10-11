<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\CloudinaryService;

class VehicleType extends Model
{
    use HasFactory;

    public const ICON_DISK = 'public';

    protected $fillable = [
        'vehicle_type',
        'vehicle_features',
        'description',
        'icon',
        'status',
    ];

    protected $casts = [
        'vehicle_features' => 'array',   // DB me JSON text, PHP me array
        'status'           => 'boolean',
    ];


    /* Is type ki gaadiyan */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }


    public function iconUrl(): ?string
    {
        return CloudinaryService::url($this->icon);
    }


    /* Admin API ka response */
    public function toApiArray(): array
    {
        return [
            'id'               => $this->id,
            'vehicle_type'     => $this->vehicle_type,
            'vehicle_features' => array_values($this->vehicle_features ?? []),
            'description'      => $this->description,
            'icon_url'         => $this->iconUrl(),
            'status'           => (bool) $this->status,
            'created_at'       => optional($this->created_at)->toIso8601String(),
            'updated_at'       => optional($this->updated_at)->toIso8601String(),
        ];
    }


    /* Public API ka response (sirf active types, status nahi bhejte) */
    public function toPublicArray(): array
    {
        return [
            'id'               => $this->id,
            'vehicle_type'     => $this->vehicle_type,
            'vehicle_features' => array_values($this->vehicle_features ?? []),
            'description'      => $this->description,
            'icon_url'         => $this->iconUrl(),
            // withCount('vehicles') laga ho tabhi aata hai
            'vehicles_count'   => $this->getAttribute('vehicles_count') !== null ? (int) $this->vehicles_count : null,
        ];
    }
}