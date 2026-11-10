<?php

namespace App\Repositories;

use App\Models\Language;

/**
 * Class LanguageRepository
 *
 * @version July 3, 2020, 9:12 am UTC
 */
class LanguageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'language',
        'iso_code',
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
        return Language::class;
    }
}
