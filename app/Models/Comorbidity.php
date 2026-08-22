<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comorbidity extends Model
{
    protected $table = 'comorbidity';
    protected $primaryKey = 'comorbidity_id';
    public $timestamps = false;

    protected $fillable = [
        'label',
        'type',
    ];

    public function consultations()
    {
        return $this->belongsToMany(
            Consultation::class,
            'consultation_comorbidity',
            'comorbidity_id',
            'consultation_id'
        )->withPivot('severity');
    }
}