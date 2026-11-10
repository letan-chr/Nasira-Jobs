<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateEmployerProfileRequest;
use App\Models\Company;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

/**
 * Class EmployerController
 */
class EmployerController extends AppBaseController
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

    public function profileUpdate(UpdateEmployerProfileRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            $employer = $this->userRepository->profileUpdate($input);
            Flash::success(__('messages.flash.employer_profile'));

            return $this->sendResponse($employer, __('messages.flash.employer_profile'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified User.
     */
    public function editProfile(): JsonResponse
    {
        $user = Auth::user();
        $data['employer'] = $user;
        $data['company'] = Company::where('user_id', $user->id)->first();

        return $this->sendResponse($data, 'Employer retrieved successfully.');
    }
}
