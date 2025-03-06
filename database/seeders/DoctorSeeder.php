<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        DB::table('doctors')->insert([
            [
                'name' => 'Dr. John Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password123'),
                'clinic_address' => '123 Main St, New York, NY',
                'phone_number' => '1234567890',
                'deposit_required' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Jane Smith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('password123'),
                'clinic_address' => '456 Elm St, Chicago, IL',
                'phone_number' => '0987654321',
                'deposit_required' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
