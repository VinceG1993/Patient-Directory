<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordField extends Model
{
    use HasFactory;

    protected $table = 'medical_record_fields';

    protected $fillable = [
        'field_name',
        'field_type',
        'is_active',
        'is_required',
        'default_value',
        'doctor_id'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class);
    } 
}
