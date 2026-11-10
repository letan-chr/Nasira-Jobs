<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Language
 *
 * @version July 3, 2020, 9:12 am UTC
 *
 * @property int $id
 * @property string $language
 * @property string|null $iso_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereIsoCode($value)
 * @method static Builder|Language whereLanguage($value)
 * @method static Builder|Language whereUpdatedAt($value)
 *
 * @mixin Eloquent
 *
 * @property-read Collection|User[] $candidate
 * @property-read int|null $candidate_count
 */
class Language extends Model
{
    public $table = 'languages';

    public $fillable = [
        'language',
        'iso_code',
        'is_default',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'language' => 'string',
        'iso_code' => 'string',
        'is_default' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'language' => 'required|unique:languages,language|max:150',
        'iso_code' => 'required|unique:languages,iso_code|max:150',
    ];

    public function candidate(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'candidate_language');
    }
}
