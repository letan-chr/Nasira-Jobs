<?php

namespace App\Repositories;

use App\Models\Testimonial;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class TestimonialRepository
 */
class TestimonialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_name',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Testimonial::class;
    }

    public function store($input): bool
    {
        try {
            /** @var Testimonial $testimonial */
            $testimonial = $this->create($input);

            if (isset($input['customer_image']) && ! empty($input['customer_image'])) {
                $testimonial->addMedia($input['customer_image'])->toMediaCollection(Testimonial::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function updateTestimonial($input, $testimonialId)
    {
        try {
            /** @var Testimonial $testimonial */
            $testimonial = $this->update($input, $testimonialId);

            if (! empty($input['customer_image'])) {
                $testimonial->clearMediaCollection(Testimonial::PATH);
                $testimonial->addMedia($input['customer_image'])->toMediaCollection(Testimonial::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
