<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchise_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile', 20);
            $table->string('email')->nullable();
            $table->string('partnership_type');   // franchise, fleet, rental, charging, delivery
            $table->string('investment');
            $table->boolean('has_property');
            $table->string('space');
            $table->string('experience');
            $table->string('fleet_size');
            $table->boolean('consent')->default(false);
            $table->enum('status', ['pending', 'contacted', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'partnership_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_applications');
    }
};