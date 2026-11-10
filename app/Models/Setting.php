<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 *
 * @mixin \Eloquent
 *
 * @property-read mixed $logo_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 */
class Setting extends Model implements HasMedia
{
    use InteractsWithMedia, QueryCacheable;

    public $cacheFor = 3600; // cache time, in seconds

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    public const PATH = 'settings';

    public $table = 'settings';

    public $fillable = [
        'key',
        'value',
    ];

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

    /**
     * @return mixed
     */
    public function getLogoUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PATH)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset($this->value);
    }

    public const COLOR = [
        '0' => '#5EBEC4',
        '1' => '#2568FB',
        '2' => '#6E6E6E',
        '3' => '#394F8A',
        '4' => '#4A5FC1',
        '5' => '#BD1E51',
        '6' => '#490B3D',
        '7' => '#161F6D',
        '8' => '#00A9D8',
        '9' => '#7DA2A9',
        '10' => '#8DA242',
        '11' => '#D48166',
        '12' => '#438945',
        '13' => '#5C6E58',
        '14' => '#E60576',
        '15' => '#FB9039',
        '16' => '#0B4141',
        '17' => '#3F6844',
    ];
}
