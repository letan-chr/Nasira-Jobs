<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvSetting extends Model
{
    use HasFactory;

    public $table = 'env_settings';

    public $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'key' => 'string',
        'value' => 'string',
    ];
}
