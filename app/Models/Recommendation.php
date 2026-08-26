<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendation';
    protected $primaryKey = 'recommendation_id';
    public $timestamps = false;

    public const STATUS_PROPOSED = 'proposed';
    public const STATUS_VALIDATED = 'validated';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_RCP = 'rcp';

    protected $fillable = [
        'consultation_id',
        'recommendation_type',
        'generation_date',
        'status',
        'rule_id',
        'recommendation_text',
        'justification',
        'source',
        'grade',
        'abc_type',
        'conflict',
        'conflict_reason',
        'details',
    ];

    protected $casts = [
        'generation_date' => 'datetime',
        'conflict' => 'boolean',
        'details' => 'array',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'consultation_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_VALIDATED => 'Validated',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_RCP => 'Sent to RCP',
            default => 'Pending Review',
        };
    }
}
