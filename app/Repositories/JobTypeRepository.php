<?php

namespace App\Repositories;

use App\Models\JobType;

/**
 * Class JobTypeRepository
 *
 * @version June 22, 2020, 5:43 am UTC
 */
class JobTypeRepository extends BaseRepository
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
        return JobType::class;
    }
}
