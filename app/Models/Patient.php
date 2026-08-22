<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patient_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth',
        'sex', 'medical_record_number', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at'    => 'datetime',
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'patient_id', 'patient_id');
    }

    // Age calculé, pas stocké
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    // Dernière consultation (pour Stage + Last Updated)
    public function latestConsultation()
    {
        return $this->hasOne(Consultation::class, 'patient_id', 'patient_id')
                    ->latestOfMany('consultation_date');
    }
}
