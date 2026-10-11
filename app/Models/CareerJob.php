<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerJob extends Model
{
    use HasFactory;

    protected $table = 'career_jobs';

    /**
     * Department key => name, short name, icon
     */
    public const DEPARTMENTS = [
        'sales' => [
            'name' => 'Sales & Telecalling',
            'short' => 'Sales',
            'icon' => 'phone',
        ],

        'engineering' => [
            'name' => 'Engineering',
            'short' => 'Engineering',
            'icon' => 'code',
        ],

        'operations' => [
            'name' => 'Operations',
            'short' => 'Operations',
            'icon' => 'settings',
        ],

        'support' => [
            'name' => 'Customer Support',
            'short' => 'Support',
            'icon' => 'headset',
        ],

        'design' => [
            'name' => 'Design',
            'short' => 'Design',
            'icon' => 'pen',
        ],

        'marketing' => [
            'name' => 'Marketing',
            'short' => 'Marketing',
            'icon' => 'megaphone',
        ],
    ];

    public const WORK_MODES = [
        'On-site',
        'Hybrid',
        'Remote',
    ];

    public const JOB_TYPES = [
        'Full-time',
        'Part-time',
        'Internship',
        'Contract',
    ];

    public const SHIFTS = [
        'Day',
        'Night',
        'Flexible',
    ];

    public const SALARY_PERIODS = [
        'month',
        'year',
    ];

    protected $fillable = [
        'title',
        'department',
        'city',
        'work_mode',
        'job_type',
        'shift',
        'experience',
        'salary',
        'salary_period',
        'languages',
        'openings',
        'description',
        'requirements',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'openings' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Active jobs only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Department display name
     */
    public function getDepartmentNameAttribute(): string
    {
        return self::DEPARTMENTS[$this->department]['name']
            ?? ucfirst((string) $this->department);
    }

    /**
     * Requirements text => array
     */
    public function getRequirementsListAttribute(): array
    {
        return collect(
            preg_split('/\r\n|\r|\n/', (string) $this->requirements)
        )
            ->map(function ($line) {
                return trim(
                    ltrim(trim($line), '-•*')
                );
            })
            ->filter()
            ->values()
            ->all();
    }
}