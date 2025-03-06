<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'password' => Hash::make('password123'), // Hash the password
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'phone_number' => '0987654321',
                'home_address' => '321 Pine St, Dallas, TX',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'phone_number' => '1112223333',
                'home_address' => '456 Cedar Ave, Seattle, WA',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
