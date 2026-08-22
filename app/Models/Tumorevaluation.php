<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TumorEvaluation extends Model
{
    protected $table = 'tumor_evaluation';
    protected $primaryKey = 'evaluation_id';
    public $timestamps = false;

    protected $fillable = [
        'consultation_id',
        'resectability',
        'ca19_9_level',
        'cholestasis',
        'ca19_9_date',
        'surgery_contraindication',
        'comments',
    ];

    protected $casts = [
        'cholestasis' => 'boolean',
        'surgery_contraindication' => 'boolean',
        'ca19_9_date' => 'date',
        'ca19_9_level' => 'decimal:2',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'consultation_id');
    }
}