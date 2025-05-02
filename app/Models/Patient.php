<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'mname', 'lname', 'email', 'phone_number', 'home_address', 'doctor_id'
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}
