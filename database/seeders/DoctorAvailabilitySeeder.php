<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DoctorAvailabilitySeeder extends Seeder
{
    public function run()
    {
        $doctors = DB::table('doctors')->pluck('id');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($doctors as $doctor_id) {
            foreach ($days as $day) {
                DB::table('doctor_availability')->insert([
                    'doctor_id'  => $doctor_id,
                    'day_of_week' => $day,
                    'start_time' => Carbon::createFromTime(rand(8, 12), 0, 0)->format('H:i:s'),
                    'end_time'   => Carbon::createFromTime(rand(13, 18), 0, 0)->format('H:i:s'),
                ]);
            }
        }
    }
}
