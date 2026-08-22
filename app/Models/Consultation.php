<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultation';
    protected $primaryKey = 'consultation_id';
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consultation_date',
        'performance_status',
        'clinical_stage',
    ];

    protected $casts = [
        'consultation_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id');
    }

    public function tumorEvaluation()
    {
        return $this->hasOne(TumorEvaluation::class, 'consultation_id', 'consultation_id');
    }

    public function comorbidities()
    {
        return $this->belongsToMany(
            Comorbidity::class,
            'consultation_comorbidity',
            'consultation_id',
            'comorbidity_id'
        )->withPivot('severity');
    }
}