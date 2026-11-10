<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;

/**
 * Class UserController
 */
class UserController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            $user = $this->userRepository->changePassword($input);

            return $this->sendSuccess(__('messages.flash.password_update'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    public function profileUpdate(UpdateUserProfileRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            $user = $this->userRepository->profileUpdate($input);

            return $this->sendResponse($user, __('messages.flash.profile_update'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified User.
     */
    public function editProfile(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    public function updateLanguage(Request $request): JsonResponse
    {
        $language = $request->get('language');

        /** @var User $user */
        $user = getLoggedInUser();
        $user->update(['language' => $language]);
        if(!empty($language)){
            Session::put('languageName', $language);
        }

        return $this->sendSuccess(__('messages.flash.language_update'));
    }

    public function changeThemeMode(): RedirectResponse
    {
        $user = User::find(getLoggedInUser()->id);

        if ($user->theme_mode == User::LIGHT_MODE) {
            $user['theme_mode'] = User::DARK_MODE;
        } else {
            $user['theme_mode'] = User::LIGHT_MODE;
        }

        $user->update();

        $previous = URL::previous();
        $appUrl = rtrim((string) config('app.url'), '/');
        if (! $previous || ! str_starts_with($previous, $appUrl.'/')) {
            return back();
        }

        return redirect($previous);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminIndex(): View
    {
        return view('admins.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminCreate(Request $request): View
    {
        $roles = \Spatie\Permission\Models\Role::whereNotIn('name', ['Employer', 'Candidate'])
            ->pluck('name', 'name')
            ->toArray();

        return view('admins.create', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminStore(CreateAdminRequest $request): RedirectResponse
    {
        $input = $request->all();

        $admin = $this->userRepository->adminStore($input);

        Flash::success(__('messages.flash.admin_save'));

        return redirect(route('admin.index'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminEdit(User $user): View
    {
        if ($user->hasRole('Admin') || $user->can('access_admin_panel')) {
            $user->phone = preparePhoneNumber($user->phone, $user->region_code);
        } else {
            return view('errors.404');
        }

        $roles = \Spatie\Permission\Models\Role::whereNotIn('name', ['Employer', 'Candidate'])
            ->pluck('name', 'name')
            ->toArray();

        return view('admins.edit', compact('user', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminUpdate(User $user, UpdateAdminRequest $request): RedirectResponse
    {
        $input = $request->all();

        $this->userRepository->updateAdmin($user, $input);

        Flash::success(__('messages.flash.admin_update'));

        return redirect(route('admin.index'));
    }

    public function adminDestroy(User $user): JsonResponse
    {
        $Models = [
            Candidate::class,
            Company::class,
            Job::class,
        ];
        $result = canDelete($Models, 'last_change', $user->id);
        if ($result) {
            return $this->sendError(__('messages.flash.admin_cant_delete'));
        }

        $result = canDelete([Transaction::class], 'approved_id', $user->id);
        if ($result) {
            return $this->sendError(__('messages.flash.admin_cant_delete'));
        }

        if ($user->hasRole('Admin')) {
            $user->delete();
        } else {
            return $this->sendError(__('messages.common.seems_message'));
        }

        return $this->sendSuccess(__('messages.flash.admin_delete'));
    }
}
