<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;

    protected $table = 'career_applications';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'department',
        'position',
        'city',
        'experience',
        'languages',
        'expected_salary',
        'notice_period',
        'resume',
        'message',
        'consent',
        'status',
        'admin_remarks',
    ];

    protected $casts = [
        'consent' => 'boolean',
    ];
}