<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends AppBaseController
{
    /**
     * @return Factory|View
     */
    public function dashboard(): View
    {
        /** @var User $user */
        return view('candidate.dashboard.dashboard');
    }
}
