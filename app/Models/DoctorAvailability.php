<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;

    protected $table = 'doctor_availability';
    
    protected $fillable = ['user_id', 'day_of_week', 'start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
