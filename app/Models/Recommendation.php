<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendation';
    protected $primaryKey = 'recommendation_id';
    public $timestamps = false;

    protected $fillable = [
        'consultation_id',
        'recommendation_type',
        'generation_date',
        'status',
    ];

    protected $casts = [
        'generation_date' => 'datetime',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'consultation_id');
    }
}