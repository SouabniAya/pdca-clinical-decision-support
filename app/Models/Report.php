<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    protected $primaryKey = 'report_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'date_from', 'date_to', 'file_path',
        'generated_by', 'status', 'created_at',
    ];

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by', 'user_id');
    }
}