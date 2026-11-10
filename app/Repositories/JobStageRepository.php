<?php

namespace App\Repositories;

use App\Models\JobStage;

/**
 * Class JobStageRepository
 */
class JobStageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
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
        return JobStage::class;
    }
}
