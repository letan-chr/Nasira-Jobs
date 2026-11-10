<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateCvDesign extends Model
{
    protected $fillable = [
        'user_id',
        'cv_template_id',
        'title',
        'content',
        'html',
        'css',
        'project_json',
        'settings',
        'is_default',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'project_json' => 'array',
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }
}
