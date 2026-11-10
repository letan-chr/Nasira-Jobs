<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class SalaryCurrency
 *
 * @version July 7, 2020, 6:41 am UTC
 *
 * @property string $currency_name
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency whereCurrencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalaryCurrency whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property string $currency_icon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryCurrency whereCurrencyIcon($value)
 *
 * @property string $currency_code
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SalaryCurrency whereCurrencyCode($value)
 */
class SalaryCurrency extends Model
{
    public $table = 'salary_currencies';

    public $fillable = [
        'currency_name',
        'is_default',
        'currency_code',
        'currency_icon',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'currency_name' => 'string',
        'is_default' => 'boolean',
        'currency_code' => 'string',
        'currency_icon' => 'string',
    ];

    public static $rules = [
        'currency_name' => 'required|string|unique:salary_currencies,currency_name',
        'currency_icon' => 'required|unique:salary_currencies,currency_icon',
        'currency_code' => 'required|min:3|max:3|unique:salary_currencies,currency_code',
    ];
}
