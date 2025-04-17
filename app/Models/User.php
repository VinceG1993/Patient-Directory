<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'clinic_address', 'phone_number',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships for doctor's availability and appointments
    public function availability()
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function medicalrecordfields()
    {
        return $this->hasMany(MedicalRecordField::class);
    }
}
