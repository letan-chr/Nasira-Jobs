<?php

namespace App\Repositories;

use App\Models\CareerLevel;

/**
 * Class CareerLevelRepository
 *
 * @version July 7, 2020, 5:07 am UTC
 */
class CareerLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'level_name',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CareerLevel::class;
    }
}
