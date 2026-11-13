<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobRole extends Model
{
    protected $table = 'job_roles';

    protected $fillable = [
        'job_id',
        'title',
        'requirements',
        'sort_order',
    ];

    protected $casts = [
        'job_id' => 'integer',
        'sort_order' => 'integer',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
