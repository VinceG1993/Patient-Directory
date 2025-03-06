<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalRecordFieldsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medical_record_fields')->insert([
            [
                'field_name' => 'Blood Pressure',
                'field_type' => 'text',
                'is_active' => true,
                'is_required' => true,
                'default_value' => null,
            ],
            [
                'field_name' => 'Heart Rate',
                'field_type' => 'number',
                'is_active' => true,
                'is_required' => true,
                'default_value' => '0',
            ],
            [
                'field_name' => 'Date of Visit',
                'field_type' => 'date',
                'is_active' => true,
                'is_required' => true,
                'default_value' => null,
            ],
            [
                'field_name' => 'Diabetic',
                'field_type' => 'boolean',
                'is_active' => true,
                'is_required' => false,
                'default_value' => '0',
            ],
            [
                'field_name' => 'Allergies',
                'field_type' => 'text',
                'is_active' => true,
                'is_required' => false,
                'default_value' => null,
            ],
        ]);
    }
}
