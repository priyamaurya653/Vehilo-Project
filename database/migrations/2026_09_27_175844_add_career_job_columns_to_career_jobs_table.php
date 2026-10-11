<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('career_jobs', function (Blueprint $table) {

            if (!Schema::hasColumn('career_jobs', 'title')) {
                $table->string('title')->after('id');
            }

            if (!Schema::hasColumn('career_jobs', 'department')) {
                $table->string('department', 50)->after('title');
            }

            if (!Schema::hasColumn('career_jobs', 'city')) {
                $table->string('city', 100)->after('department');
            }

            if (!Schema::hasColumn('career_jobs', 'work_mode')) {
                $table->string('work_mode', 20)
                    ->default('On-site')
                    ->after('city');
            }

            if (!Schema::hasColumn('career_jobs', 'job_type')) {
                $table->string('job_type', 20)
                    ->default('Full-time')
                    ->after('work_mode');
            }

            if (!Schema::hasColumn('career_jobs', 'shift')) {
                $table->string('shift', 20)
                    ->nullable()
                    ->after('job_type');
            }

            if (!Schema::hasColumn('career_jobs', 'experience')) {
                $table->string('experience', 30)
                    ->after('shift');
            }

            if (!Schema::hasColumn('career_jobs', 'salary')) {
                $table->string('salary', 50)
                    ->after('experience');
            }

            if (!Schema::hasColumn('career_jobs', 'salary_period')) {
                $table->string('salary_period', 10)
                    ->default('month')
                    ->after('salary');
            }

            if (!Schema::hasColumn('career_jobs', 'languages')) {
                $table->string('languages', 150)
                    ->nullable()
                    ->after('salary_period');
            }

            if (!Schema::hasColumn('career_jobs', 'openings')) {
                $table->unsignedSmallInteger('openings')
                    ->default(1)
                    ->after('languages');
            }

            if (!Schema::hasColumn('career_jobs', 'description')) {
                $table->text('description')
                    ->nullable()
                    ->after('openings');
            }

            if (!Schema::hasColumn('career_jobs', 'requirements')) {
                $table->text('requirements')
                    ->nullable()
                    ->after('description');
            }

            if (!Schema::hasColumn('career_jobs', 'is_active')) {
                $table->boolean('is_active')
                    ->default(true)
                    ->after('requirements');
            }

            if (!Schema::hasColumn('career_jobs', 'sort_order')) {
                $table->unsignedInteger('sort_order')
                    ->default(0)
                    ->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('career_jobs', function (Blueprint $table) {

            $columns = [
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
                'description',
                'requirements',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('career_jobs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};