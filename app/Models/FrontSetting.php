<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\FrontSetting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontSetting whereValue($value)
 *
 * @mixin Eloquent
 *
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 */
class FrontSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'front_settings';

    public $fillable = [
        'key',
        'value',
    ];

    const FEATURED_JOBS_ENABLED = 1;

    public const PATH = 'advertise_image';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'key' => 'required',
        'value' => 'required',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'value' => 'string',
    ];
}
