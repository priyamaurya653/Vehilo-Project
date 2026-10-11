<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riders', function (Blueprint $table) {

            $table->id();

            // Personal Information
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('mobile', 15)->unique();

            // Extra Fields
            $table->string('alternate_mobile', 15)->nullable();
            $table->enum('gender', [
                'male',
                'female',
                'other'
            ])->nullable();

            $table->string('city');
            $table->string('pincode', 10)->nullable();
            $table->text('address')->nullable();

            // OTP Verification
            $table->string('otp', 6)->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            // KYC
            $table->string('aadhaar', 12)->nullable();
            $table->date('date_of_birth')->nullable();

            $table->enum('kyc_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            // Driving License
            $table->string('driving_license_number')->nullable();

            // Documents
            $table->string('government_id')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('passport_photo')->nullable();

            // Rider Account Status
            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'rejected'
            ])->default('pending');

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};