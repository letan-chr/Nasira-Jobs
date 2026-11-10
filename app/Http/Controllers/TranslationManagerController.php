<?php

namespace App\Http\Controllers;

use App\Repositories\TranslationManagerRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class TranslationManagerController extends AppBaseController
{
    /**
     * @var TranslationManagerRepository
     */
    private $translateManagerRepo;

    public function __construct(TranslationManagerRepository $translateManagerRepo)
    {
        $this->translateManagerRepo = $translateManagerRepo;
    }

    /**
     * Display a listing of the FAQ.
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        $selectedLang = $request->get('name', 'en');
        $selectedFile = $request->get('file', 'messages.php');
        $langExists = $this->translateManagerRepo->checkLanguageExistOrNot($selectedLang);
        if (! $langExists) {
            return redirect()->back()->withErrors($selectedLang.' language not found.');
        }

        $fileExists = $this->translateManagerRepo->checkFileExistOrNot($selectedLang, $selectedFile);
        if (! $fileExists) {
            return redirect()->back()->withErrors($selectedFile.' file not found.');
        }

        $oldLang = app()->getLocale();
        $data = $this->translateManagerRepo->getSubDirectoryFiles($selectedLang, $selectedFile);
        app()->setLocale($oldLang);

        return view('translation-manager.index', compact('selectedLang', 'selectedFile'))->with($data);
    }

    public function store(Request $request): JsonResponse
    {
//        return $this->sendError('This action is not allow in demo');

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/u|min:2|max:2',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->getMessageBag()->getMessages()['name'][0]);
        }
        $input = $request->all();
        $this->translateManagerRepo->store($input);

        return $this->sendSuccess(__('messages.flash.language_added'));
    }

    public function update(Request $request): RedirectResponse
    {
//        Flash::error('This action is not allow in demo');

//        return Redirect::back();

        $lName = $request->get('translate_language');
        $fileName = $request->get('file_name');
        $fileExists = $this->translateManagerRepo->checkFileExistOrNot($lName, $fileName);
        if (! $fileExists) {
            return redirect()->back()->withErrors('File not found.');
        }

        if (! empty($lName)) {
            $result = $request->except(['_token', 'translate_language', 'file_name']);
            File::put(base_path('lang/'.$lName.'/'.$fileName), '<?php return '.var_export($result, true).'?>');
        }
        Flash::success(__('messages.flash.translation_update'));

        return redirect()->route('translation-manager.index');
    }
}
