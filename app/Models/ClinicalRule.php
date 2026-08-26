<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalRule extends Model
{
    protected $table = 'clinical_rule';
    protected $primaryKey = 'clinical_rule_id';

    protected $fillable = [
        'rule_id',
        'title',
        'category',
        'conditions',
        'recommendation',
        'justification',
        'source',
        'grade',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public const CATEGORIES = [
        'resectable' => 'Resectable',
        'borderline' => 'Borderline',
        'locally_advanced' => 'Locally Advanced',
        'metastatic' => 'Metastatic',
        'overlay' => 'Overlay (any stage)',
        'conflict' => 'Conflict / RCP',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ($this->category ?? '—');
    }
}
