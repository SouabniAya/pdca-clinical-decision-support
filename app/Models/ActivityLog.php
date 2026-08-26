<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $table = 'activity_log';
    protected $primaryKey = 'activity_id';
    public $timestamps = false;

    public const TYPE_PATIENT_CREATED = 'patient_created';
    public const TYPE_PATIENT_UPDATED = 'patient_updated';
    public const TYPE_STATUS_CHANGED = 'status_changed';
    public const TYPE_CLINICAL_DATA_UPDATED = 'clinical_data_updated';
    public const TYPE_RECOMMENDATION_GENERATED = 'recommendation_generated';
    public const TYPE_RECOMMENDATION_STATUS_CHANGED = 'recommendation_status_changed';

    protected $fillable = [
        'type',
        'message',
        'detail',
        'patient_id',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Write one activity feed entry.
     *
     * $patientId is optional (not every event is patient-scoped, though
     * today all of them are). $userId defaults to the current auth user
     * when available — falls back to null ("System") since the app's
     * auth is not fully wired everywhere yet.
     */
    public static function log(
        string $type,
        string $message,
        ?string $detail = null,
        ?int $patientId = null,
        ?int $userId = null
    ): self {
        return static::create([
            'type' => $type,
            'message' => $message,
            'detail' => $detail,
            'patient_id' => $patientId,
            'user_id' => $userId ?? Auth::id(),
            'created_at' => now(),
        ]);
    }

    /**
     * Icon bucket used by the dashboard blade — collapses the specific
     * $type values above into the 4 icon styles the UI already has
     * (update / recommendation / new / status).
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_PATIENT_CREATED => 'new',
            self::TYPE_STATUS_CHANGED => 'status',
            self::TYPE_RECOMMENDATION_GENERATED,
            self::TYPE_RECOMMENDATION_STATUS_CHANGED => 'recommendation',
            default => 'update',
        };
    }
}
