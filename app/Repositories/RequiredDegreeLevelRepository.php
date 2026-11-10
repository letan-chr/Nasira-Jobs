<?php

namespace App\Repositories;

use App\Models\RequiredDegreeLevel;

/**
 * Class RequiredDegreeLevelRepository
 *
 * @version June 30, 2020, 12:30 pm UTC
 */
class RequiredDegreeLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return RequiredDegreeLevel::class;
    }
}
