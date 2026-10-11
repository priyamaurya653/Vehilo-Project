<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerApplication extends Model
{
    use HasFactory;

    protected $table = 'partner_applications';

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'email',
        'partnership_type',
        'investment',
        'property',
        'space',
        'experience',
        'fleet_size',
        'consent',
        'status',
    ];

    protected $casts = [
        'consent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}