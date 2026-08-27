<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RcpMeeting extends Model
{
    protected $table = 'rcp_meeting';
    protected $primaryKey = 'rcp_meeting_id';

    protected $fillable = [
        'recommendation_id',
        'meeting_date',
        'participants',
        'final_decision',
        'deviates_from_recommendation',
        'deviation_reason',
        'notes',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'deviates_from_recommendation' => 'boolean',
    ];

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id', 'recommendation_id');
    }
}
