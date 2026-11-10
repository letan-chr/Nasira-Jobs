<?php

namespace App\Repositories;

use App\Models\FunctionalArea;

/**
 * Class FunctionalAreaRepository
 *
 * @version July 4, 2020, 7:26 am UTC
 */
class FunctionalAreaRepository extends BaseRepository
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
        return FunctionalArea::class;
    }
}
