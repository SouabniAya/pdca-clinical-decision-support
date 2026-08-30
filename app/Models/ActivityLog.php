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
        'admin_id',
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

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    /**
     * Write one activity feed entry.
     *
     * $patientId is optional (not every event is patient-scoped, though
     * today all of them are). If neither $userId nor $adminId is passed
     * explicitly, we detect the currently authenticated actor from
     * whichever guard is active (web = doctor/nurse/visitor, admin = admin)
     * and fill the matching column. Falls back to "System" (both null)
     * if nobody is authenticated.
     */
    public static function log(
        string $type,
        string $message,
        ?string $detail = null,
        ?int $patientId = null,
        ?int $userId = null,
        ?int $adminId = null
    ): self {
        if ($userId === null && $adminId === null) {
            if (Auth::guard('web')->check()) {
                $userId = Auth::guard('web')->id();
            } elseif (Auth::guard('admin')->check()) {
                $adminId = Auth::guard('admin')->id();
            }
        }

        return static::create([
            'type' => $type,
            'message' => $message,
            'detail' => $detail,
            'patient_id' => $patientId,
            'user_id' => $userId,
            'admin_id' => $adminId,
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

    /**
     * Convenience accessor: returns the display name of whoever
     * performed this action, regardless of whether they were a
     * doctor/nurse/visitor (user_id) or an admin (admin_id).
     */
    public function getActorNameAttribute(): string
    {
        if ($this->user) {
            return trim($this->user->first_name . ' ' . $this->user->last_name);
        }

        if ($this->admin) {
            return trim($this->admin->first_name . ' ' . $this->admin->last_name);
        }

        return 'System';
    }
}