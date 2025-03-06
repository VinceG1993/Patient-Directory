<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'patient_id', 'record_date', 'notes', 'record_data'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
