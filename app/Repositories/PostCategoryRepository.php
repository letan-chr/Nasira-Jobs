<?php

namespace App\Repositories;

use App\Models\PostCategory;

/**
 * Class PostCategoryRepository
 */
class PostCategoryRepository extends BaseRepository
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
        return PostCategory::class;
    }
}
