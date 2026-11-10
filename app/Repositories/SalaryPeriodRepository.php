<?php

namespace App\Repositories;

use App\Models\SalaryPeriod;

/**
 * Class SalaryPeriodRepository
 *
 * @version June 23, 2020, 5:43 am UTC
 */
class SalaryPeriodRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'period',
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
        return SalaryPeriod::class;
    }
}
