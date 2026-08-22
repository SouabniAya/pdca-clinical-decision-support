<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';
    protected $primaryKey = 'user_id';
    public $incrementing = false; // user_id vient de 'users', pas d'auto-increment propre
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'license_number',
        'specialty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}