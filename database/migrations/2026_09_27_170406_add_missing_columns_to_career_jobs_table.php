<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * career_jobs table pehle se bani thi (purane structure me).
 * Ye migration sirf wahi columns jodti hai jo missing hain – data safe rehta hai.
 */
return new class extends Migration
{
    private array $columns = [
        'title'         => ['string', 255, null],
        'department'    => ['string', 50, 'sales'],
        'city'          => ['string', 100, 'Remote'],
        'work_mode'     => ['string', 20, 'On-site'],
        'job_type'      => ['string', 20, 'Full-time'],
        'shift'         => ['string', 20, null],
        'experience'    => ['string', 30, ''],
        'salary'        => ['string', 50, ''],
        'salary_period' => ['string', 10, 'month'],
        'languages'     => ['string', 150, null],
        'openings'      => ['smallint', null, 1],
        'description'   => ['text', null, null],
        'requirements'  => ['text', null, null],
        'is_active'     => ['boolean', null, true],
        'sort_order'    => ['int', null, 0],
    ];

    public function up(): void
    {
        if (! Schema::hasTable('career_jobs')) {
            return; // table hi nahi hai to create wali migration chalegi
        }

        foreach ($this->columns as $name => [$type, $length, $default]) {
            if (Schema::hasColumn('career_jobs', $name)) {
                continue;
            }

            Schema::table('career_jobs', function (Blueprint $table) use ($name, $type, $length, $default) {
                $col = match ($type) {
                    'string'   => $table->string($name, $length),
                    'text'     => $table->text($name),
                    'smallint' => $table->unsignedSmallInteger($name),
                    'int'      => $table->unsignedInteger($name),
                    'boolean'  => $table->boolean($name),
                };

                // text columns aur jinka default null hai -> nullable
                if ($type === 'text' || $default === null) {
                    $col->nullable();
                } else {
                    $col->default($default);
                }
            });
        }

        if (! Schema::hasColumn('career_jobs', 'created_at')) {
            Schema::table('career_jobs', fn (Blueprint $t) => $t->timestamps());
        }
    }

    public function down(): void
    {
        // Jaan-bujh kar khali: purane columns ko rollback me nahi hataते
    }
};