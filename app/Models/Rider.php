<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rider extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riders';

    public const DOCUMENT_TYPES = ['government_id', 'address_proof', 'passport_photo'];
    public const KYC_STATUSES   = ['pending', 'verified', 'rejected'];
    public const STATUSES       = ['pending', 'active', 'inactive', 'rejected'];

    protected $fillable = [
        'user_id',

        'full_name',
        'email',
        'mobile',
        'alternate_mobile',
        'gender',
        'city',
        'pincode',
        'address',

        'otp',
        'otp_verified_at',

        'aadhaar',
        'date_of_birth',
        'kyc_status',

        'driving_license_number',

        'government_id',
        'address_proof',
        'passport_photo',

        'status',
        'approved_at',
    ];

    protected $hidden = [
        'otp',
        'aadhaar',
        'government_id',
        'address_proof',
        'passport_photo',
    ];

    protected $casts = [
        'date_of_birth'   => 'date',
        'otp_verified_at' => 'datetime',
        'approved_at'     => 'datetime',
    ];


    /* Login account */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | API response format (sab APIs yahi use karti hain)
    | Aadhaar hamesha masked jata hai, document ka path kabhi bahar nahi jata
    |--------------------------------------------------------------------------
    */
    public function toApiArray(): array
    {
        return [
            'id'                     => $this->id,
            'user_id'                => $this->user_id,

            'full_name'              => $this->full_name,
            'email'                  => $this->email,
            'mobile'                 => $this->mobile,
            'alternate_mobile'       => $this->alternate_mobile,
            'gender'                 => $this->gender,
            'city'                   => $this->city,
            'pincode'                => $this->pincode,
            'address'                => $this->address,

            'aadhaar_masked'         => $this->aadhaar ? 'XXXX XXXX ' . substr($this->aadhaar, -4) : null,
            'date_of_birth'          => optional($this->date_of_birth)->format('Y-m-d'),
            'driving_license_number' => $this->driving_license_number,

            'kyc_status'             => $this->kyc_status,
            'status'                 => $this->status,
            'mobile_verified'        => (bool) $this->otp_verified_at,
            'login_active'           => $this->user ? (bool) $this->user->status : false,

            'documents' => [
                'government_id'  => (bool) $this->government_id,
                'address_proof'  => (bool) $this->address_proof,
                'passport_photo' => (bool) $this->passport_photo,
            ],

            'otp_verified_at' => optional($this->otp_verified_at)->toIso8601String(),
            'approved_at'     => optional($this->approved_at)->toIso8601String(),
            'created_at'      => optional($this->created_at)->toIso8601String(),
            'updated_at'      => optional($this->updated_at)->toIso8601String(),
        ];
    }
}