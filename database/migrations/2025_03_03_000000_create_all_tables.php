<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 42);
            $table->string('email', 42)->unique();
            $table->string('password', 60);
            $table->string('clinic_address', 255);
            $table->string('phone_number', 15);
            $table->timestamps();
        });

        // Doctor Availability Table
        Schema::create('doctor_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('start_time');
            $table->time('end_time');
        });

        // Patients Table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 42);
            $table->string('email', 42);
            $table->string('phone_number', 15);
            $table->string('home_address', 255);
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Medical Records Table
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->dateTime('record_date');
            $table->text('notes');
            $table->json('record_data')->nullable();
        });

        // Medical Record Fields Table
        Schema::create('medical_record_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name', 255);
            $table->enum('field_type', ['text', 'number', 'date', 'boolean']);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->default(false);
            $table->string('default_value', 255)->nullable();
        });

        // Appointments Table
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed']);
            $table->boolean('deposit_paid');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('medical_record_fields');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctor_availability');
        Schema::dropIfExists('users');
    }
};
