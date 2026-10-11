<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {

            $table->id();

            // Personal Details
            $table->string('name');
            $table->string('phone', 20);
            $table->string('email');

            // Job Details
            $table->string('department');
            $table->string('position');
            $table->string('city');
            $table->string('experience');

            // Additional Details
            $table->string('languages')->nullable();
            $table->string('expected_salary');
            $table->string('notice_period');

            // Resume
            $table->string('resume')->nullable();

            // Cover Message
            $table->text('message')->nullable();

            // Consent
            $table->boolean('consent')->default(false);

            // Application Status
            $table->enum('status', [
                'pending',
                'reviewed',
                'shortlisted',
                'rejected',
                'hired'
            ])->default('pending');

            // Admin/HR Remarks
            $table->text('admin_remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};