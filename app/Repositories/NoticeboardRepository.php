<?php

namespace App\Repositories;

use Exception;
use App\Models\NewsLetter;
use App\Models\Noticeboard;
use App\Mail\NewsLetterMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class NoticeboardRepository
 */
class NoticeboardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
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
        return Noticeboard::class;
    }

    public function store($input): bool
    {
        /* @var  Noticeboard $noticeboard */
        $noticeboard = $this->create($input);

        $newsLetterEmails = NewsLetter::pluck('email')->toArray();

        $templateBody = EmailTemplate::whereTemplateName('News Letter')->first();
        foreach ($newsLetterEmails as $key => $newsLetterEmail) {
            try {
                $keyVariable = ['{{description}}', '{{from_name}}'];
                $value = [$input['description'], config('app.name')];
                $body = str_replace($keyVariable, $value, $templateBody->body);
                $data['input'] = $input;
                $data['body'] = $body;
                Mail::to($newsLetterEmail)->send(new NewsLetterMail($data));
            } catch (Exception $e) {
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }

        return true;
    }
}
