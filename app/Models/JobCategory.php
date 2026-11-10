<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class JobCategory
 *
 * @version June 19, 2020, 6:50 am UTC
 *
 * @property string $name
 * @property string $description
 * @property bool|null $is_featured
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobCategory whereIsFeatured($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read int|null $jobs_count
 */
class JobCategory extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const PATH = 'job_category';

    public $table = 'job_categories';

    public $fillable = [
        'name',
        'description',
        'is_featured',
        'is_default',
    ];
    const ALL = 2;
    const IS_FEATURED = 1;
    const NOT_FEATURED = 0;
    const FEATURED = [
        self::ALL => 'all',
        self::IS_FEATURED => 'featured',
        self::NOT_FEATURED => 'not_featured',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:160|unique:job_categories,name',
        'customer_image' => 'nullable|mimes:jpeg,jpg,png',
    ];

    protected $appends = ['image_url', 'is_featured_label'];

    /**
     * @return mixed
     */
    public function getImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/nasira-placeholder.png');
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'is_featured' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function getIsFeaturedLabelAttribute(): string
    {
        return self::FEATURED[$this->is_featured];
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }
}
