<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'super@gmail.com',
            ],
            [
                'name' => 'VEHILO Super Admin',
                'mobile' => '9999999999',
                'password' => Hash::make('super@12345'),
                'role' => 'superadmin',
                'status' => 1,
            ]
        );
    }
}