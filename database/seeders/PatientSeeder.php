<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run()
    {
        DB::table('patients')->insert([
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'phone_number' => '1234567890',
                'home_address' => '789 Oak St, Miami, FL',
                'doctor_id' => 1, // Assuming the user with ID 1 is the assigned doctor
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'phone_number' => '0987654321',
                'home_address' => '321 Pine St, Dallas, TX',
                'doctor_id' => 2, // Assuming the user with ID 2 is the assigned doctor
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'phone_number' => '1112223333',
                'home_address' => '456 Cedar Ave, Seattle, WA',
                'doctor_id' => 3, // Assuming the user with ID 3 is the assigned doctor
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
