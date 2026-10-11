<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('partner_applications');

        Schema::create('partner_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('mobile', 20);
            $table->string('email');

            $table->string('partnership_type');
            $table->string('investment');
            $table->string('property');
            $table->string('space');
            $table->string('experience');
            $table->string('fleet_size');

            $table->boolean('consent')->default(false);
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_applications');
    }
};