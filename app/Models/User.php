<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'location',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Full name accessor — lets auth()->user()->name work in Blade views
    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'user_id');
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class, 'user_id', 'user_id');
    }

    public function visitor()
    {
        return $this->hasOne(Visitor::class, 'user_id', 'user_id');
    }
}