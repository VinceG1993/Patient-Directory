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
                'fname' => 'Alice',
                'mname' => 'Sophia',
                'lname' => 'Johnson',
                'email' => 'alice@example.com',
                'phone_number' => '1234567890',
                'home_address' => '789 Oak St, Miami, FL',
                'doctor_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'fname' => 'Bob',
                'mname' => 'Marley',
                'lname' => 'Smith',
                'email' => 'bob@example.com',
                'phone_number' => '0987654321',
                'home_address' => '321 Pine St, Dallas, TX',
                'doctor_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'fname' => 'Charlie',
                'mname' => 'Felix',
                'lname' => 'Brown',
                'email' => 'charlie@example.com',
                'phone_number' => '1112223333',
                'home_address' => '456 Cedar Ave, Seattle, WA',
                'doctor_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
