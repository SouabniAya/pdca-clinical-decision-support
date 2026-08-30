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

    /**
     * Toutes les recommandations du patient, via ses consultations.
     */
    public function recommendations()
    {
        return $this->hasManyThrough(
            Recommendation::class,
            Consultation::class,
            'patient_id',        // clé étrangère sur consultation
            'consultation_id',   // clé étrangère sur recommendation
            'patient_id',        // clé locale sur patient
            'consultation_id'    // clé locale sur consultation
        );
    }

    /**
     * La recommandation la plus récente du patient (accessor,
     * utilisée dans PatientController via $patient->latestRecommendation).
     */
    public function getLatestRecommendationAttribute()
    {
        return $this->recommendations()
                    ->orderByDesc('generation_date')
                    ->first();
    }
}