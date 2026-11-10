<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CvTemplate extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'category',
        'accent_color',
        'secondary_color',
        'layout',
        'description',
        'html',
        'css',
        'project_json',
        'thumbnail',
        'is_active',
        'is_premium',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];

    public function designs(): HasMany
    {
        return $this->hasMany(CandidateCvDesign::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }
}
