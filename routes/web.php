<?php

use App\Http\Controllers\Web;
use App\Http\Controllers\Candidates;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\JobShiftController;
use App\Http\Controllers\JobStageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\CareerLevelController;
use App\Http\Controllers\CmsServicesController;
use App\Http\Controllers\CompanySizeController;
use App\Http\Controllers\ImageSliderController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\NoticeboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HeaderSliderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\SalaryPeriodController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\FrontSettingsController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\OwnerShipTypeController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\BrandingSliderController;
use App\Http\Controllers\FunctionalAreaController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SalaryCurrencyController;
use App\Http\Controllers\JobNotificationController;
use App\Http\Controllers\TranslationManagerController;
use App\Http\Controllers\RequiredDegreeLevelController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\FeaturedJobSubscriptionController;
use App\Http\Controllers\FeaturedCompanySubscriptionController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {
        return view('front_web.home.home');
    }
)->name('web.home');

Auth::routes(['verify' => true, 'register' => false]);
Route::middleware('setLanguage')->group(
    function () {
        Route::get('admin/login', [\App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name(
            'admin.login'
        );
        Route::post('users/login', [\App\Http\Controllers\Auth\Front\LoginController::class, 'login'])->name(
            'front.login'
        )->middleware('verified.user');
        Route::get(
            'users/employee-login',
            [\App\Http\Controllers\Auth\Front\LoginController::class, 'employeeLogin']
        )->name('front.employee.login');
        Route::get(
            'users/candidate-login',
            [\App\Http\Controllers\Auth\Front\LoginController::class, 'candidateLogin']
        )->name('front.candidate.login');

        Route::get('password/reset', [\App\Http\Controllers\Auth\LoginController::class, 'showResetEmailPage'])
            ->name('password.request');

        Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\LoginController::class, 'showResetPassword'])
            ->name('password.reset');
    }
);
Route::get(
    'pricing',
    function () {
        return view('pricing.index');
    }
);

//Theme-Mode
Route::get('theme-mode', [UserController::class, 'changeThemeMode'])->name('theme.mode');

Route::any('subscription-update', [SubscriptionController::class, 'updateSubscription'])->name('subscription-update');

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [Web\WebController::class, 'index'])->name('front');

Route::middleware('setLanguage')->group(function () {
    Route::post('news-letter', [Web\WebController::class, 'newsLetter'])->name('news-letter.create');
});

Route::middleware('auth', 'role_or_permission:Admin|access_admin_panel', 'xss', 'verified.user')->prefix('admin')->group(function () {
         // dashboard route
         Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
         Route::get('/dashboard-chart-data', [DashboardController::class, 'dashboardChartData'])->name('dashboard.chart.data');

         // Read notification
         //    Route::post('/notification/{notification}/read',
         //        [NotificationController::class, 'readNotification'])->name('read-notification');
         //    Route::post('/read-all-notification', [NotificationController::class, 'readAllNotification'])->name('read-all-notification');

         // subscribers route
         Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
         Route::delete('subscribers/{newsLetter}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
         Route::get(
                  'change-transaction-status/{id}',
                  [SubscriptionController::class, 'changeTransactionStatus']
         )->name('change-transaction-status');

         // Job Category routes
         Route::get('job-categories', [JobCategoryController::class, 'index'])->name('job-categories.index');
         Route::post('job-categories', [JobCategoryController::class, 'store'])->name('job-categories.store');
         Route::get('job-categories/{jobCategory}/edit', [JobCategoryController::class, 'edit'])->name('job-categories.edit');
         Route::get('job-categories/{jobCategory}', [JobCategoryController::class, 'show'])->name('job-categories.show');
         Route::post('job-categories/{jobCategory}', [JobCategoryController::class, 'update'])->name('job-categories.update');
         Route::delete('job-categories/{jobCategory}', [JobCategoryController::class, 'destroy'])->name('job-categories.destroy');
         Route::post('job-categories/{jobCategory}/change-status', [JobCategoryController::class, 'changeStatus'])->name('change-status');

         // settings routes
         Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
         Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

         // Privacy Policy routes
         Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.policy.index');
         Route::post('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy.policy.update');

         // Company Size
         Route::get('company-sizes', [CompanySizeController::class, 'index'])->name('companySize.index');
         Route::post('company-sizes', [CompanySizeController::class, 'store'])->name('companySize.store');
         Route::get('company-sizes/{companySize}/edit', [CompanySizeController::class, 'edit'])->name('companySize.edit');
         Route::put('company-sizes/{companySize}', [CompanySizeController::class, 'update'])->name('companySize.update');
         Route::delete('company-sizes/{companySize}', [CompanySizeController::class, 'destroy'])->name('companySize.destroy');

         //Skills
         Route::get('skills', [SkillController::class, 'index'])->name('skills.index');
         Route::post('skills', [SkillController::class, 'store'])->name('skills.store');
         Route::get('skills/{skill}', [SkillController::class, 'show'])->name('skills.show');
         Route::get('skills/{skill}/edit', [SkillController::class, 'edit'])->name('skills.edit');
         Route::put('skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
         Route::delete('skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

         // Marital Status
         Route::get('marital-status', [MaritalStatusController::class, 'index'])->name('maritalStatus.index');
         Route::post('marital-status', [MaritalStatusController::class, 'store'])->name('maritalStatus.store');
         Route::get('marital-status/{maritalStatus}', [MaritalStatusController::class, 'show'])->name('maritalStatus.show');
         Route::get(
                  'marital-status/{maritalStatus}/edit',
                  [MaritalStatusController::class, 'edit']
         )->name('maritalStatus.edit');
         Route::put(
                  'marital-status/{maritalStatus}',
                  [MaritalStatusController::class, 'update']
         )->name('maritalStatus.update');
         Route::delete(
                  'marital-status/{maritalStatus}',
                  [MaritalStatusController::class, 'destroy']
         )->name('maritalStatus.destroy');

         // Salary Period
         Route::get('salary-periods', [SalaryPeriodController::class, 'index'])->name('salaryPeriod.index');
         Route::post('salary-periods', [SalaryPeriodController::class, 'store'])->name('salaryPeriod.store');
         Route::get('salary-periods/{salaryPeriod}', [SalaryPeriodController::class, 'show'])->name('salaryPeriod.show');
         Route::get('salary-periods/{salaryPeriod}/edit', [SalaryPeriodController::class, 'edit'])->name('salaryPeriod.edit');
         Route::put('salary-periods/{salaryPeriod}', [SalaryPeriodController::class, 'update'])->name('salaryPeriod.update');
         Route::delete('salary-periods/{salaryPeriod}', [SalaryPeriodController::class, 'destroy'])->name('salaryPeriod.destroy');

         // Job Shift
         Route::get('job-shifts', [JobShiftController::class, 'index'])->name('jobShift.index');
         Route::post('job-shifts', [JobShiftController::class, 'store'])->name('jobShift.store');
         Route::get('job-shifts/{jobShift}', [JobShiftController::class, 'show'])->name('jobShift.show');
         Route::get('job-shifts/{jobShift}/edit', [JobShiftController::class, 'edit'])->name('jobShift.edit');
         Route::put('job-shifts/{jobShift}', [JobShiftController::class, 'update'])->name('jobShift.update');
         Route::delete('job-shifts/{jobShift}', [JobShiftController::class, 'destroy'])->name('jobShift.destroy');

         // Required Degree Level
         Route::get('degree-levels', [RequiredDegreeLevelController::class, 'index'])->name('requiredDegreeLevel.index');
         Route::post('degree-levels', [RequiredDegreeLevelController::class, 'store'])->name('requiredDegreeLevel.store');
         Route::get(
                  'degree-levels/{requiredDegreeLevel}',
                  [RequiredDegreeLevelController::class, 'show']
         )->name('requiredDegreeLevel.show');
         Route::get(
                  'degree-levels/{requiredDegreeLevel}/edit',
                  [RequiredDegreeLevelController::class, 'edit']
         )->name('requiredDegreeLevel.edit');
         Route::put(
                  'degree-levels/{requiredDegreeLevel}',
                  [RequiredDegreeLevelController::class, 'update']
         )->name('requiredDegreeLevel.update');
         Route::delete(
                  'degree-levels/{requiredDegreeLevel}',
                  [RequiredDegreeLevelController::class, 'destroy']
         )->name('requiredDegreeLevel.destroy');

         // All Candidate Resumes
         Route::get('resumes', [CandidateController::class, 'resumes'])->name('resumes.index');
         Route::get('/media/{media?}', [CandidateController::class, 'downloadResume'])->name('download.all-resume');
         Route::delete(
                  'delete-resumes/{media?}',
                  [CandidateController::class, 'deleteResume']
         )->name('delete.resume');

         // Job Tags
         Route::get('job-tags', [TagController::class, 'index'])->name('jobTag.index');
         Route::post('job-tags', [TagController::class, 'store'])->name('jobTag.store');
         Route::get('job-tags/{tag}', [TagController::class, 'show'])->name('jobTag.show');
         Route::get('job-tags/{tag}/edit', [TagController::class, 'edit'])->name('jobTag.edit');
         Route::put('job-tags/{tag}', [TagController::class, 'update'])->name('jobTag.update');
         Route::delete('job-tags/{tag}', [TagController::class, 'destroy'])->name('jobTag.destroy');

         // Job Types
         Route::get('job-types', [JobTypeController::class, 'index'])->name('jobType.index');
         Route::post('job-types', [JobTypeController::class, 'store'])->name('jobType.store');
         Route::get('job-types/{jobType}', [JobTypeController::class, 'show'])->name('jobType.show');
         Route::get('job-types/{jobType}/edit', [JobTypeController::class, 'edit'])->name('jobType.edit');
         Route::put('job-types/{jobType}', [JobTypeController::class, 'update'])->name('jobType.update');
         Route::delete('job-types/{jobType}', [JobTypeController::class, 'destroy'])->name('jobType.destroy');

         // OwnerShip Type
         Route::get('ownership-types', [OwnerShipTypeController::class, 'index'])->name('ownerShipType.index');
         Route::post('ownership-types', [OwnerShipTypeController::class, 'store'])->name('ownerShipType.store');
         Route::get('ownership-types/{ownerShipType}/edit', [OwnerShipTypeController::class, 'edit'])->name('ownerShipType.edit');
         Route::get('ownership-types/{ownerShipType}', [OwnerShipTypeController::class, 'show'])->name('ownership-types.show');
         Route::put('ownership-types/{ownerShipType}', [OwnerShipTypeController::class, 'update'])->name('ownerShipType.update');
         Route::delete('ownership-types/{ownerShipType}', [OwnerShipTypeController::class, 'destroy'])->name('ownerShipType.destroy');

         // Industries
         Route::get('industries', [IndustryController::class, 'index'])->name('industry.index');
         Route::post('industries', [IndustryController::class, 'store'])->name('industry.store');
         Route::get('industries/{industry}', [IndustryController::class, 'show'])->name('industry.show');
         Route::get('industries/{industry}/edit', [IndustryController::class, 'edit'])->name('industry.edit');
         Route::put('industries/{industry}', [IndustryController::class, 'update'])->name('industry.update');
         Route::delete('industries/{industry}', [IndustryController::class, 'destroy'])->name('industry.destroy');

         //Admins
         Route::get('admins', [UserController::class, 'adminIndex'])->name('admin.index');
         Route::get('admins/create', [UserController::class, 'adminCreate'])->name('admin.create');
         Route::post('admins', [UserController::class, 'adminStore'])->name('admin.store');
         Route::get('admins/{user}/edit', [UserController::class, 'adminEdit'])->name('admin.edit');
         Route::put('admins/{user}', [UserController::class, 'adminUpdate'])->name('admin.update');
         Route::delete('admins/{user}', [UserController::class, 'adminDestroy'])->name('admin.destroy');

         // Roles & Permissions
         Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
         Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
         Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
         Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
         Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
         Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

         // Employers
         Route::get('employers', [CompanyController::class, 'index'])->name('company.index');
         Route::get('employers/create', [CompanyController::class, 'create'])->name('company.create');
         Route::post('employers', [CompanyController::class, 'store'])->name('company.store');
         Route::get('employers/{company}', [CompanyController::class, 'show'])->name('company.show');
         Route::get('employers/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
         Route::put('employers/{company}', [CompanyController::class, 'update'])->name('company.update');
         Route::delete('employers/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');
         Route::post('employers/{company}/change-is-active', [CompanyController::class, 'changeIsActive'])->name('change.company.status');
         Route::post('employers/{company}/verify-email', [CompanyController::class, 'changeIsEmailVerified'])->name('company.verified.email');
         Route::post('employers/{company}/resend-email-verification', [CompanyController::class, 'resendEmailVerification'])->name('company.resendEmailVerification');
         Route::post(
                  'employers/{company}/mark-as-featured',
                  [CompanyController::class, 'markAsFeatured']
         )->name('mark-as-featured');
         Route::post(
                  'employers/{company}/mark-as-unfeatured',
                  [CompanyController::class, 'markAsUnFeatured']
         )->name('mark-as-unfeatured');

         // Language routes
         Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
         Route::post('languages', [LanguageController::class, 'store'])->name('languages.store');
         Route::get('languages/{language}/edit', [LanguageController::class, 'edit'])->name('languages.edit');
         Route::get('languages/{language}', [LanguageController::class, 'show'])->name('languages.show');
         Route::put('languages/{language}', [LanguageController::class, 'update'])->name('languages.update');
         Route::delete('languages/{language}', [LanguageController::class, 'destroy'])->name('languages.destroy');
         Route::post('languages/{language}/{param}/change-status', [LanguageController::class, 'changeStatus']);

         // Functional Area
         Route::get('functional-areas', [FunctionalAreaController::class, 'index'])->name('functionalArea.index');
         Route::post('functional-areas', [FunctionalAreaController::class, 'store'])->name('functionalArea.store');
         Route::get(
                  'functional-areas/{functionalArea}/edit',
                  [FunctionalAreaController::class, 'edit']
         )->name('functionalArea.edit');
         Route::put(
                  'functional-areas/{functionalArea}',
                  [FunctionalAreaController::class, 'update']
         )->name('functionalArea.update');
         Route::delete(
                  'functional-areas/{functionalArea}',
                  [FunctionalAreaController::class, 'destroy']
         )->name('functionalArea.destroy');

         // Career Level
         Route::get('career-levels', [CareerLevelController::class, 'index'])->name('careerLevel.index');
         Route::post('career-levels', [CareerLevelController::class, 'store'])->name('careerLevel.store');
         Route::get(
                  'career-levels/{careerLevel}/edit',
                  [CareerLevelController::class, 'edit']
         )->name('careerLevel.edit');
         Route::put(
                  'career-levels/{careerLevel}',
                  [CareerLevelController::class, 'update']
         )->name('careerLevel.update');
         Route::delete(
                  'career-levels/{careerLevel}',
                  [CareerLevelController::class, 'destroy']
         )->name('careerLevel.destroy');

         Route::get('profile', [UserController::class, 'editProfile'])->name('user-profile');
         Route::post('change-password', [UserController::class, 'changePassword'])->name('user-change-password');
         Route::post('profile-update', [UserController::class, 'profileUpdate'])->name('user-profile-update');

         // Salary Currency
         Route::get('salary-currencies', [SalaryCurrencyController::class, 'index'])->name('salaryCurrency.index');
         Route::post('salary-currencies', [SalaryCurrencyController::class, 'store'])->name('salaryCurrency.store');
         Route::get(
                  'salary-currencies/{currency}/edit',
                  [SalaryCurrencyController::class, 'edit']
         )->name('salaryCurrency.edit');
         Route::put(
                  'salary-currencies/{currency}',
                  [SalaryCurrencyController::class, 'update']
         )->name('salaryCurrency.update');
         Route::delete(
                  'salary-currencies/{currency}',
                  [SalaryCurrencyController::class, 'destroy']
         )->name('salaryCurrency.destroy');

         // jobs route
         Route::get('jobs', [JobController::class, 'getJobs'])->name('admin.jobs.index');
         Route::get('jobs/create', [JobController::class, 'createJob'])->name('admin.job.create');
         Route::post('jobs', [JobController::class, 'storeJob'])->name('admin.job.store');
         Route::get('jobs/{job}/edit', [JobController::class, 'editJob'])->name('admin.job.edit');
         Route::put('jobs/{job}', [JobController::class, 'updateJob'])->name('admin.job.update');
         Route::get('jobs/{job}', [JobController::class, 'showJobs'])->name('admin.jobs.show');
         Route::delete('jobs/{job}', [JobController::class, 'delete'])->name('admin.jobs.destroy');
         Route::post('jobs/{job}/change-is-suspend', [JobController::class, 'changeIsSuspended'])->name('job.is-suspend');
         Route::post('jobs/{job}/make-job-featured', [JobController::class, 'makeFeatured'])->name('job.make.featured');
         Route::post('jobs/{job}/make-job-unfeatured', [JobController::class, 'makeUnFeatured'])->name('job.make.unfeatured');

         Route::get('pending-jobs', [JobController::class, 'getPendingJobs'])->name('admin.PendingJobs.index');
         Route::get('pending-jobs-add-reason', [JobController::class, 'getPendingJobsAddReason'])->name('admin.PendingJobs.AddReason');
         Route::post('pending-jobs-change-status', [JobController::class, 'getPendingJobsChangeStatus'])->name('admin.PendingJobs.changStatus');


         //job expired
         Route::get('expired-jobs', [JobController::class, 'getExpiredJobs'])->name('admin.jobs.expiredJobs');

         // candidate routes
         Route::get('candidates', [CandidateController::class, 'index'])->name('candidates.index');
         Route::get('candidates/create', [CandidateController::class, 'create'])->name('candidates.create');
         Route::post('candidates', [CandidateController::class, 'store'])->name('candidates.store');
         Route::get('candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
         Route::get('candidates/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
         Route::put('candidates/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
         Route::delete('candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
         Route::post('candidates/{id}/change-status', [CandidateController::class, 'changeStatus'])->name('candidate.changeStatus');
         Route::post(
                  'candidates/{candidate}/verify-email',
                  [CandidateController::class, 'changeIsEmailVerified']
         )->name('candidate.changeIsEmailVerified');
         Route::post('candidates/{candidate}/resend-email-verification', [CandidateController::class, 'resendEmailVerification'])->name('candidate.resendEmailVerification');

         //Testimonials  routes
         Route::get('testimonials', [TestimonialsController::class, 'index'])->name('testimonials.index');
         Route::post('testimonials', [TestimonialsController::class, 'store'])->name('testimonials.store');
         Route::get('testimonials/{testimonial}/edit', [TestimonialsController::class, 'edit'])->name('testimonials.edit');
         Route::get('testimonials/{testimonial}', [TestimonialsController::class, 'show'])->name('testimonials.show');
         Route::post('testimonials/{testimonial}/update', [TestimonialsController::class, 'update'])->name('testimonials.update');
         Route::delete('testimonials/{testimonial}', [TestimonialsController::class, 'destroy'])->name('testimonials.destroy');
         Route::get('/download-image/{testimonial?}', [TestimonialsController::class, 'downloadImage'])->name('download.image');

         //Front Image Slider Routes
         Route::get('image-sliders', [ImageSliderController::class, 'index'])->name('image-sliders.index');
         Route::post('image-sliders', [ImageSliderController::class, 'store'])->name('image-sliders.store');
         Route::get('image-sliders/{image_slider}/edit', [ImageSliderController::class, 'edit'])->name('image-sliders.edit');
         Route::post('image-sliders/{image_slider}/update', [ImageSliderController::class, 'update'])->name('image-sliders.update');
         Route::delete('image-sliders/{image_slider}', [ImageSliderController::class, 'destroy'])->name('image-sliders.destroy');
         Route::get('image-sliders/{image_slider}', [ImageSliderController::class, 'show'])->name('image-sliders.show');
         Route::post('image-sliders/{image_slider}/change-is-active', [ImageSliderController::class, 'changeIsActive'])->name('image-slider-change-is-active');
         Route::post(
                  'image-sliders/change-full-slider',
                  [ImageSliderController::class, 'changeFullSlider']
         )->name('image-sliders.change-full-slider');
         Route::post(
                  'image-sliders/change-slider-active',
                  [ImageSliderController::class, 'changeSliderActive']
         )->name('image-sliders.change-slider-active');

         //Front Header Slider Routes
         Route::get('header-sliders', [HeaderSliderController::class, 'index'])->name('header.sliders.index');
         Route::post('header-sliders', [HeaderSliderController::class, 'store'])->name('header.sliders.store');
         Route::get('header-sliders/{header_slider}/edit', [HeaderSliderController::class, 'edit'])->name('header.sliders.edit');
         Route::post(
                  'header-sliders/{header_slider}/update',
                  [HeaderSliderController::class, 'update']
         )->name('header.sliders.update');
         Route::delete('header-sliders/{header_slider}', [HeaderSliderController::class, 'destroy'])->name('header.sliders.destroy');
         Route::post('header-sliders/{header_slider}/change-is-active', [HeaderSliderController::class, 'changeIsActive'])->name('header-slider-change-is-active');
         Route::post(
                  'header-sliders/change-search-disable',
                  [HeaderSliderController::class, 'changeSearchDisable']
         )->name('header.sliders.change-search-disable');

         //Front Branding Slider Routes
         Route::get('branding-sliders', [BrandingSliderController::class, 'index'])->name('branding.sliders.index');
         Route::post('branding-sliders', [BrandingSliderController::class, 'store'])->name('branding.sliders.store');
         Route::get(
                  'branding-sliders/{brandingSlider}/edit',
                  [BrandingSliderController::class, 'edit']
         )->name('branding.sliders.edit');
         Route::post(
                  'branding-sliders/{brandingSlider}/update',
                  [BrandingSliderController::class, 'update']
         )->name('branding.sliders.update');
         Route::delete(
                  'branding-sliders/{brandingSlider}',
                  [BrandingSliderController::class, 'destroy']
         )->name('branding.sliders.destroy');
         Route::post('branding-sliders/{brandingSlider}/change-is-active', [BrandingSliderController::class, 'changeIsActive'])->name('branding-slider-change-is-active');

         // Noticeboard Routes
         Route::get('noticeboards', [NoticeboardController::class, 'index'])->name('noticeboards.index');
         Route::post('noticeboards', [NoticeboardController::class, 'store'])->name('noticeboards.store');
         Route::get('noticeboards/{noticeboard}', [NoticeboardController::class, 'show'])->name('noticeboards.show');
         Route::get('noticeboards/{noticeboard}/edit', [NoticeboardController::class, 'edit'])->name('noticeboards.edit');
         Route::put('noticeboards/{noticeboard}', [NoticeboardController::class, 'update'])->name('noticeboards.update');
         Route::delete('noticeboards/{noticeboard}', [NoticeboardController::class, 'destroy'])->name('noticeboards.destroy');
         Route::post('noticeboards/{id}/change-status', [NoticeboardController::class, 'changeStatus'])->name('noticeboard.status');

         // cms services
         Route::get('cms-services', [CmsServicesController::class, 'index'])->name('cms.services.index');
         Route::get('cms-about-us', [CmsServicesController::class, 'aboutUsService'])->name('cms.about-us.service');
         Route::post('cms-services', [CmsServicesController::class, 'update'])->name('cms.services.update');
         Route::post('cms-about-us', [CmsServicesController::class, 'aboutUsUpdate'])->name('cms.about-us.update');
         // FAQ routes
         Route::get('faqs', [FAQController::class, 'index'])->name('faqs.index');
         Route::post('faqs', [FAQController::class, 'store'])->name('faqs.store');
         Route::get('faqs/{faq}', [FAQController::class, 'show'])->name('faqs.show');
         Route::get('faqs/{faq}/edit', [FAQController::class, 'edit'])->name('faqs.edit');
         Route::put('faqs/{faq}', [FAQController::class, 'update'])->name('faqs.update');
         Route::delete('faqs/{faq}', [FAQController::class, 'destroy'])->name('faqs.destroy');

         // inquires listing route
         Route::get('inquires', [InquiryController::class, 'index'])->name('inquires.index');
         Route::get('inquires/{inquiry}', [InquiryController::class, 'show'])->name('inquires.show');
         Route::delete('inquires/{inquiry}', [InquiryController::class, 'destroy'])->name('inquires.destroy');

         // Post Category Routes
         Route::get('post-categories', [PostCategoryController::class, 'index'])->name('post-categories.index');
         Route::post('post-categories', [PostCategoryController::class, 'store'])->name('post-categories.store');
         Route::get('post-categories/{postCategory}', [PostCategoryController::class, 'show'])->name('post-categories.show');
         Route::get('post-categories/{postCategory}/edit', [PostCategoryController::class, 'edit'])->name('post-categories.edit');
         Route::put('post-categories/{postCategory}', [PostCategoryController::class, 'update'])->name('post-categories.update');
         Route::delete('post-categories/{postCategory}', [PostCategoryController::class, 'destroy'])->name('post-categories.destroy');

         // Post Routes
         Route::get('posts', [PostController::class, 'index'])->name('posts.index');
         Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
         Route::post('posts', [PostController::class, 'store'])->name('posts.store');
         Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
         Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
         Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
         Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
         Route::get('posts/media/{media?}', [PostController::class, 'downloadPost'])->name('download.post');

         //Post Comments
         Route::get('post-comments', [PostController::class, 'getAllComments'])->name('post.comments');
         Route::get('post-comments/{postComment}', [PostController::class, 'showComment'])->name('post.comments.show');

         // Reported Job Listing
         Route::get('reported-jobs', [JobController::class, 'showReportedJobs'])->name('reported.jobs');
         Route::get('reported-jobs/{reportedJob}', [JobController::class, 'showReportedJobNote'])->name('reported.jobs.show');
         Route::delete('reported-jobs/{reportedJob}', [JobController::class, 'deleteReportedJobs'])->name('delete.reported.jobs');

         //Reported company
         Route::get('reported-employers', [CompanyController::class, 'showReportedCompanies'])->name('reported.companies');
         Route::get(
                  'reported-employers/{reportedToCompany}',
                  [CompanyController::class, 'showReportedCompanyNote']
         )->name('reported.companies.show');
         Route::delete(
                  'reported-employers/{reportedToCompany}',
                  [CompanyController::class, 'deleteReportedCompany']
         )->name('delete.reported.company');

         //Reported candidate
         Route::get('reported-candidates', [CandidateController::class, 'showReportedCandidates'])->name('reported.candidates');
         Route::get(
                  'reported-candidates/{reportedToCandidate}',
                  [CandidateController::class, 'showReportedCandiateNote']
         )->name('reported.candidates.show');
         Route::delete(
                  'reported-candidates/{reportedToCandidate}',
                  [CandidateController::class, 'deleteReportedCandidate']
         )->name('delete.reported.candidate');

         //Selected Candidate
         Route::get('selected-candidates', [JobApplicationController::class, 'showAllSelectedCandidate'])->name('selected.candidate');

         // plans routes
         Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
         Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
         Route::get('plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
         Route::put('plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
         Route::delete('plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
         Route::post('plans/{plan}/change-trial-plan', [PlanController::class, 'changeTrialPlan'])->name('plans.change-trial-plan');

         // transactions route
         Route::get('transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
         Route::get('invoices/{invoiceId}', [TransactionController::class, 'getTransactionInvoice'])->name('transaction-invoice');

         //Email template route
         Route::get('email-template', [EmailTemplateController::class, 'index'])->name('email.template.index');
         Route::get(
                  'email-template/{emailTemplate}/edit',
                  [EmailTemplateController::class, 'edit']
         )->name('email.template.edit');
         Route::put(
                  'email-template/{emailTemplate}',
                  [EmailTemplateController::class, 'update']
         )->name('email.template.update');

         // Appearance (theme tokens)
         Route::get('appearance', [AppearanceController::class, 'index'])->name('appearance.index');
         Route::post('appearance', [AppearanceController::class, 'update'])->name('appearance.update');
         Route::post('appearance/reset', [AppearanceController::class, 'reset'])->name('appearance.reset');

         // Telegram channel sync test
         Route::get('telegram/test', [TelegramController::class, 'test'])->name('telegram.test');

         // Front setting routes
         Route::get('front-settings', [FrontSettingsController::class, 'index'])->name('front.settings.index');
         Route::post('front-settings', [FrontSettingsController::class, 'update'])->name('front.settings.update');
         Route::post('front-settings/{id}/change-is-job-active', [FrontSettingsController::class, 'changeJobFeatured'])->name('change-is-job-active');
         Route::post(
                  'front-settings/{id}/change-is-company-active',
                  [FrontSettingsController::class, 'changeCompanyFeatured']
         )->name('change-is-company-active');
         Route::post(
                  'front-settings/{id}/change-is-job-country-active',
                  [FrontSettingsController::class, 'changeJobCountry']
         )->name('change-is-job-country-active');

         // Notification setting routes
         Route::get(
                  'notification-settings',
                  [NotificationSettingsController::class, 'index']
         )->name('notification.settings.index');
         Route::post(
                  'notification-settings',
                  [NotificationSettingsController::class, 'update']
         )->name('notification.settings.update');

         //Candidate Excel
         Route::get(
                  'candidates-export-excel',
                  [CandidateController::class, 'candidateExportExcel']
         )->name('candidates.export.excel');

         // Country routes
         Route::get('countries', [CountryController::class, 'index'])->name('countries.index');
         Route::post('countries', [CountryController::class, 'store'])->name('countries.store');
         Route::get('countries/{country}/edit', [CountryController::class, 'edit'])->name('countries.edit');
         Route::put('countries/{country}', [CountryController::class, 'update'])->name('countries.update');
         Route::delete('countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy');

         // State routes
         Route::get('states', [StateController::class, 'index'])->name('states.index');
         Route::post('states', [StateController::class, 'store'])->name('states.store');
         Route::get('states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');
         Route::put('states/{state}', [StateController::class, 'update'])->name('states.update');
         Route::delete('states/{state}', [StateController::class, 'destroy'])->name('states.destroy');

         // City routes
         Route::get('cities', [CityController::class, 'index'])->name('cities.index');
         Route::post('cities', [CityController::class, 'store'])->name('cities.store');
         Route::get('cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
         Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
         Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

         Route::get('job-notifications', [JobNotificationController::class, 'index'])->name('job-notification.index');
         Route::post('job-notifications', [JobNotificationController::class, 'store'])->name('job-notification.store');
         Route::get('employer-jobs/{id?}', [JobNotificationController::class, 'getEmployerJobs'])->name('get-employer.jobs');

        //  Route::get('translation-manager', [TranslationManagerController::class, 'index'])->name('translation-manager.index');
        //  Route::post('translation-manager', [TranslationManagerController::class, 'store'])->name('translation-manager.store');
        //  Route::post(
        //           'translation-manager/update',
        //           [TranslationManagerController::class, 'update']
        //  )->name('translation-manager.update');
});

Route::middleware('auth', 'role:Admin|Employer|Candidate', 'xss', 'verified.user')->group(function () {
    Route::get('states-list', [JobController::class, 'getStates'])->name('states-list');
    Route::get('cities-list', [JobController::class, 'getCities'])->name('cities-list');
    Route::post('update-language', [UserController::class, 'updateLanguage'])->name('update-language');

    // Read notification
    Route::post(
        '/notification/{notification}/read',
        [NotificationController::class, 'readNotification']
    )->name('read-notification');
    Route::post('/read-all-notification', [NotificationController::class, 'readAllNotification'])->name('read-all-notification');

    // job stripe payment
    Route::post('job-stripe-charge', [FeaturedJobSubscriptionController::class, 'createSession'])->name('job-stripe-charge');
    Route::get('job-payment-success', [FeaturedJobSubscriptionController::class, 'paymentSuccess'])->name('job-payment-success');
    Route::get(
        'job-failed-payment',
        [FeaturedJobSubscriptionController::class, 'handleFailedPayment']
    )->name('job-failed-payment');

    // companie stripe payment
    Route::post('company-stripe-charge', [FeaturedCompanySubscriptionController::class, 'createSession'])->name('company-stripe-charge');
    Route::get(
        'company-payment-success',
        [FeaturedCompanySubscriptionController::class, 'paymentSuccess']
    )->name('company-payment-success');
    Route::get(
        'company-failed-payment',
        [FeaturedCompanySubscriptionController::class, 'handleFailedPayment']
    )->name('company-failed-payment');
});

Route::middleware('auth', 'role:Employer', 'xss', 'verified.user')->prefix('employer')->group(function () {
         // TODO:: need to change this
         Route::get('/employer', function () {
                  return view('employer.layouts.app');
         });

         Route::get('dashboard', [DashboardController::class, 'employerDashboard'])->name('employer.dashboard');
         Route::get(
                  'employer-dashboard-chart',
                  [DashboardController::class, 'employerDashboardChart']
         )->name('employer.dashboard.chart');
         Route::get('employer-job-data', [DashboardController::class, 'getJobData'])->name('employer.job.data');

         // Read notification
         //    Route::post('/notification/{notification}/read',
         //        [NotificationController::class, 'readNotification'])->name('read-notification');
         //    Route::post('/read-all-notification', [NotificationController::class, 'readAllNotification'])->name('read-all-notification');

         //model profile and password
         Route::get('employer-profile', [EmployerController::class, 'editProfile'])->name('employer-edit-profile');
         Route::post('employer-change-password', [EmployerController::class, 'changePassword'])->name('employer-change-password');
         Route::post('employer-profile-update', [EmployerController::class, 'profileUpdate'])->name('employer-profile-update');

         // Job Applications
         Route::get('jobs/{jobId}/applications', [JobApplicationController::class, 'index'])->name('job-applications');
         Route::post('job-applications/{id}/status/{status}', [JobApplicationController::class, 'changeJobApplicationStatus'])->name('change-job-application-status');
         Route::delete(
                  'job-applications/{jobApplication}',
                  [JobApplicationController::class, 'destroy']
         )->name('job.application.destroy');
         Route::get('resume-download/{jobApplication}', [JobApplicationController::class, 'downloadMedia']);
         //    Route::post('job-applications/get-job-stage/{Id}', [JobApplicationController::class, 'getJobStage'])->name('get.job.stage');
         Route::post('job-applications/{jobId}/job-stage', [JobApplicationController::class, 'changeJobStage'])->name('change.job.stage');
         Route::get('jobs/{jobId}/applications/{jobApplicationId}/slots', [JobApplicationController::class, 'viewSlotsScreen'])->name('view.slot.screen');
         Route::post('jobs/{jobId}/cancel-slot', [JobApplicationController::class, 'cancelSelectedSlot'])->name('cancel.selected.slot');
         Route::post('job-applications/{jobId}/slot-store', [JobApplicationController::class, 'interviewSlotStore'])->name('interview.slot.store');
         Route::get('job-applications/{jobId}/get-history-schedule', [JobApplicationController::class, 'getScheduleHistory'])->name('get.schedule.history');
         Route::post('job-applications/{jobId}/batch-slot-store', [JobApplicationController::class, 'batchSlotStore'])->name('batch.slot.store');
         Route::get('jobs/{jobId}/applications/slots/{slot}/edit', [JobApplicationController::class, 'editSlot'])->name('slot.edit');
         Route::post('jobs/{jobId}/applications/slots/{slot}/update', [JobApplicationController::class, 'updateSlot'])->name('slot.update');
         Route::delete(
                  'jobs/{jobId}/applications/slots/{slot}',
                  [JobApplicationController::class, 'slotDestroy']
         )->name('slot.destroy');
         Route::get('stage-check/{jobId?}', [JobApplicationController::class, 'checkStage'])->name('stage-check');

         // Jobs
         Route::get('jobs', [JobController::class, 'index'])->name('job.index');
         Route::get('jobs/create', [JobController::class, 'create'])->name('job.create');
         Route::post('jobs', [JobController::class, 'store'])->name('job.store');
         Route::get('jobs/{job}', [JobController::class, 'show'])->name('job.show');
         Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('job.edit');
         Route::put('jobs/{job}', [JobController::class, 'update'])->name('job.update');
         Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('job.destroy');
         Route::post('job/{id}/status/{status}', [JobController::class, 'changeJobStatus'])->name('change-job-status');

         Route::get('pending-jobs-add-reason', [JobController::class, 'getPendingJobsAddReason'])->name('employer.PendingJobs.AddReason');

         //job stage
         Route::get('job-stages', [JobStageController::class, 'index'])->name('job.stage.index');
         Route::post('job-stages', [JobStageController::class, 'store'])->name('job.stage.store');
         Route::get('job-stages/{jobStage}/edit', [JobStageController::class, 'edit'])->name('job.stage.edit');
         Route::put('job-stages/{jobStage}', [JobStageController::class, 'update'])->name('job.stage.update');
         Route::delete('job-stages/{jobStage}', [JobStageController::class, 'destroy'])->name('job.stage.destroy');
         Route::get('job-stage-show/{jobStage?}', [JobStageController::class, 'show'])->name('job.stage.show');

         Route::get('{company}/edit', [CompanyController::class, 'editCompany'])->name('company.edit.form');
         Route::put('{company}', [CompanyController::class, 'updateCompany'])->name('company.update.form');

         // followers route
         Route::get('followers', [CompanyController::class, 'getFollowers'])->name('followers.index');
         Route::post('/report-to-candidate', [CandidateController::class, 'reportCandidate'])->name('report.to.candidate');

         Route::get('manage-subscription', [SubscriptionController::class, 'index'])->name('manage-subscription.index');
         Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
         Route::post('purchase-subscription', [SubscriptionController::class, 'purchaseSubscription'])->name('purchase-subscription');
         Route::get('/paypal-status', [PaypalController::class, 'getPaymentStatus'])->name('status');
         Route::get('payment-method/{plan}', [SubscriptionController::class, 'showPaymentSelect'])->name('payment-method-screen');
         Route::get('manually-payment/{plan}', [SubscriptionController::class, 'manuallyPayment'])->name('manually-payment');
         Route::get('paypal-payment/{plan}', [PaypalController::class, 'oneTimePayment'])->name('paypal-payment');
         Route::get('paystack-onboard/{plan}', [PaystackController::class, 'redirectToGateway'])->name('paystack.payment');
         Route::post(
                  'purchase-trial-subscription',
                  [SubscriptionController::class, 'purchaseTrialSubscription']
         )->name('purchase-trial-subscription');
         Route::get('payment-success', [SubscriptionController::class, 'paymentSuccess'])->name('payment-success');
         Route::get('failed-payment', [SubscriptionController::class, 'handleFailedPayment'])->name('failed-payment');
         Route::post('cancel-subscription', [SubscriptionController::class, 'cancelSubscription'])->name('cancel-subscription');
         Route::get('invoices/{invoiceId}', [TransactionController::class, 'getTransactionInvoice'])->name('get-transaction-invoice');
});
// web routes (i.e landing pages)
Route::middleware('xss', 'setLanguage')->group(function () {
         Route::get('/', [Web\HomeController::class, 'index'])->name('front.home');
         Route::get('/sitemap.xml', [Web\SitemapController::class, 'index'])->name('front.sitemap');
         Route::get('/sitemap-pages.xml', [Web\SitemapController::class, 'pages'])->name('front.sitemap.pages');
         Route::get('/sitemap-jobs.xml', [Web\SitemapController::class, 'jobs'])->name('front.sitemap.jobs');
         Route::get('/sitemap-companies.xml', [Web\SitemapController::class, 'companies'])->name('front.sitemap.companies');
         Route::get('/sitemap-posts.xml', [Web\SitemapController::class, 'posts'])->name('front.sitemap.posts');
         Route::get('/get-jobs-search', [Web\HomeController::class, 'getJobsSearch'])->name('get.jobs.search');
         Route::get('/search-jobs', [Web\JobController::class, 'index'])->name('front.search.jobs');
         Route::get('/job-details/{uniqueId?}', [Web\JobController::class, 'jobDetails'])->name('front.job.details');
         Route::get('/company-lists', [Web\CompanyController::class, 'getCompaniesLists'])->name('front.company.lists');
         Route::redirect('/candidate-lists', '/')->name('front.candidate.lists');
         Route::get('/company-details/{uniqueId?}', [Web\CompanyController::class, 'getCompaniesDetails'])->name('front.company.details');
         Route::get('/about-us', [Web\AboutUsController::class, 'FAQLists'])->name('front.about.us');
         Route::get('/cv-design', [Web\CvDesignController::class, 'index'])->name('front.cv.design');
         Route::get('/sitemap-cv-design.xml', [Web\CvDesignController::class, 'sitemap'])->name('front.cv.sitemap');
         Route::get('/cv-design/editor/{slug?}', [Web\CvDesignController::class, 'editor'])->name('front.cv.editor');
         Route::post('/cv-design/save', [Web\CvDesignController::class, 'save'])->name('front.cv.save');
         Route::post('/cv-design/guest-draft', [Web\CvDesignController::class, 'saveGuestDraft'])->name('front.cv.guest-draft');
         Route::post('/cv-design/upload', [Web\CvDesignController::class, 'uploadImage'])->name('front.cv.upload');
         Route::delete('/cv-design/{design}', [Web\CvDesignController::class, 'destroy'])->name('front.cv.destroy');

         Route::get('/solutions', [Web\SolutionsController::class, 'index'])->name('front.solutions');
         Route::get('/sitemap-solutions.xml', [Web\SolutionsController::class, 'sitemap'])->name('front.solutions.sitemap');
         Route::get('/solutions/{slug}', [Web\SolutionsController::class, 'show'])->name('front.solutions.show');
         Route::get('/categories', [Web\CategoriesController::class, 'index'])->name('front.categories');
         Route::get('/front-register', [Web\RegisterController::class, 'candidateRegister'])->name('front.register');
         Route::get('/candidate-register', [Web\RegisterController::class, 'candidateRegister'])->name('candidate.register');
         Route::get('/employer-register', [Web\RegisterController::class, 'employerRegister'])->name('employer.register');
         Route::get('/privacy-policy-list', [Web\PrivacyPolicyController::class, 'showPrivacyPolicy'])->name('privacy.policy.list');
         Route::get('/terms-conditions-list', [Web\PrivacyPolicyController::class, 'showTermsConditions'])->name('terms.conditions.list');
         Route::get('/contact-us', function () {
                  return view('front_web.contact.index');
         })->name('front.contact');
         Route::post('/send-contact-mail', [Web\HomeController::class, 'sendContactEmail'])->name('send.contact.email');
         Route::post('/register', [Web\RegisterController::class, 'register'])->name('front.save.register');

         //Blog comments Routes
         Route::post('/posts-details/{post}/comment', [Web\PostController::class, 'blogCommentStore'])->name('blog.create.comment');
         Route::delete('/post-comments/{postComment}', [Web\PostController::class, 'blogCommentDelete'])->name('blog.delete.comment');
         Route::get('/post-comments/{postComment}', [Web\PostController::class, 'blogCommentEdit'])->name('blog.edit.comment');
         Route::put('/post-comments/{postComment}/edit', [Web\PostController::class, 'blogCommentUpdate'])->name('blog.update.comment');

         //Blog Listing
         Route::get('/posts', [Web\PostController::class, 'getBlogLists'])->name('front.post.lists');
         Route::get('/posts/details/{post}', [Web\PostController::class, 'getBlogDetails'])->name('front.posts.details');
         Route::get(
                  '/posts/category/{postCategory}',
                  [Web\PostController::class, 'getBlogDetailsByCategory']
         )->name('front.blog.category');

         //Candidate Show routes
         Route::get(
                  'candidate-details/{uniqueId}',
                  [Web\CandidateController::class, 'getCandidateDetails']
         )->name('front.candidate.details');

         //Change language
         Route::post('/change-language', [Web\HomeController::class, 'changeLanguage']);
});

Route::middleware('xss', 'verified.user', 'setLanguage')->group(function () {
    Route::get(
        'candidate-details/{uniqueId}',
        [Web\CandidateController::class, 'getCandidateDetails']
    )->name('front.candidate.details');
});

Route::middleware('auth', 'role:Candidate', 'xss', 'verified.user')->prefix('candidate')->group(function () {
    //dashboard
    Route::get('dashboard', [Candidates\DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [Candidates\CandidateController::class, 'editProfile'])->name('candidate.profile');
    Route::put('update-profile', [Candidates\CandidateController::class, 'updateProfile'])->name('candidate-profile.update');

    Route::get('edit-profile', [Candidates\CandidateController::class, 'editCandidateProfile'])->name('candidate.edit.profile');
    Route::post('edit-change-password', [Candidates\CandidateController::class, 'changePassword'])->name('candidate.change-password');
    Route::post('edit-profile-update', [Candidates\CandidateController::class, 'profileUpdate'])->name('candidate.update.profile');

    Route::post('/resumes', [Candidates\CandidateController::class, 'uploadResume'])->name('candidate.resumes');
    Route::get('/media/{media?}', [CandidateController::class, 'downloadResume'])->name('download.resume');
    Route::delete('/resumes/{media}', [Candidates\CandidateController::class, 'deletedResume'])->name('download.destroy');

    Route::post('experience', [Candidates\CandidateProfileController::class, 'createExperience'])->name('candidate.create-experience');
    Route::get(
        '/{candidateExperience}/edit-experience',
        [Candidates\CandidateProfileController::class, 'editExperience']
    )->name('candidate.edit-experience');
    Route::put('candidate-experience/{candidateExperience}', [Candidates\CandidateProfileController::class, 'updateExperience'])->name('candidate.update-experience');
    Route::delete(
        'candidate-experience/{candidateExperience}',
        [Candidates\CandidateProfileController::class, 'destroyExperience']
    )->name('experience.destroy');

    // candidate education
    Route::post('education', [Candidates\CandidateProfileController::class, 'createEducation'])->name('candidate.create-education');
    Route::get(
        '/{candidateEducation}/edit-education',
        [Candidates\CandidateProfileController::class, 'editEducation']
    )->name('candidate.edit-education');
    Route::put('candidate-education/{candidateEducation}', [Candidates\CandidateProfileController::class, 'updateEducation'])->name('candidate.update-education');
    Route::delete(
        'candidate-education/{candidateEducation}',
        [Candidates\CandidateProfileController::class, 'destroyEducation']
    )->name('education.destroy');

    // favourite jobs listing routes.
    Route::get('favourite-jobs', [Candidates\CandidateController::class, 'showFavouriteJobs'])->name('favourite.jobs');
    Route::delete('favourite-jobs/{favouriteJob}', [Candidates\CandidateController::class, 'deleteFavouriteJob'])->name('favourite.jobs.delete');

    // favourite company listing routes.
    Route::get('favourite-companies', [Candidates\CandidateController::class, 'showFavouriteCompanies'])->name('favourite.companies');
    Route::delete('favourite-companies/{id}', [Candidates\CandidateController::class, 'destroyFavouriteCompany'])->name('favourite.companies.delete');

    //applied job list routes.
    Route::get('applied-jobs', [Candidates\CandidateController::class, 'showCandidateAppliedJob'])->name('candidate.applied.job');
    Route::get(
        'applied-jobs/{jobApplication}',
        [Candidates\CandidateController::class, 'showAppliedJobs']
    )->name('candidate.applied.job.show');
    Route::post('applied-jobs/{jobApplication}/schedule-slot-book', [Candidates\CandidateController::class, 'showScheduleSlotBook'])->name('show.schedule.slot');
    Route::post('applied-jobs/{jobApplication}/choose-preference', [Candidates\CandidateController::class, 'choosePreference'])->name('choose.preference');

    // cv builder list routes.
    Route::post(
        'update-general-profile',
        [Candidates\CandidateController::class, 'updateGeneralInformation']
    )->name('candidate.general.profile.update');
    Route::get('get-cv-template', [Candidates\CandidateController::class, 'getCVTemplate'])->name('candidate.cv.template');
    Route::post(
        'update-online-profile',
        [Candidates\CandidateController::class, 'updateOnlineProfile']
    )->name('candidate.online.profile.update');

    // job alert routes.
    Route::get('job-alerts', [Candidates\CandidateController::class, 'editJobAlert'])->name('candidate.job.alert');
    Route::post('job-alerts', [Candidates\CandidateController::class, 'updateJobAlert'])->name('candidate.job.alert.update');
});

// candidates route without name space
Route::middleware('auth', 'role:Candidate', 'xss', 'verified.user', 'setLanguage')->prefix('candidate')->group(function () {
    // Read notification
    //    Route::post('/notification/{notification}/read',
    //        [NotificationController::class, 'readNotification'])->name('read-notification');
    //    Route::post('/read-all-notification', [NotificationController::class, 'readAllNotification'])->name('read-all-notification');

    Route::post('/email-job', [Web\JobController::class, 'emailJobToFriend'])->name('email.job');

    Route::post('/save-favourite-job', [Web\JobController::class, 'saveFavouriteJob'])->name('save.favourite.job');
    Route::post('/report-job', [Web\JobController::class, 'reportJobAbuse'])->name('report.job.abuse');

    Route::post('apply-job', [Web\JobApplicationController::class, 'applyJob'])->name('apply-job');

    Route::post(
        '/save-favourite-company',
        [Web\CompanyController::class, 'saveFavouriteCompany']
    )->name('save.favourite.company');
    Route::post('/report-to-company', [Web\CompanyController::class, 'reportToCompany'])->name('report.to.company');

    Route::get('apply-job/{jobId}', [Web\JobApplicationController::class, 'showApplyJobForm'])
        ->name('show.apply-job-form');
});
Route::middleware('web')->group(function () {
    Route::get('login/{provider}', [\App\Http\Controllers\Auth\Front\SocialAuthController::class, 'redirect']);
    Route::get('login/{provider}/callback', [\App\Http\Controllers\Auth\Front\SocialAuthController::class, 'callback']);
});
// ........pay stack payment .......
Route::get(
    'paystack-payment-success',
    [PaystackController::class, 'paymentSuccess']
)->name('paystack.success');

Route::middleware(['auth', 'role_or_permission:Admin|access_admin_panel'])->get('lang-js', function () {
    Artisan::call('lang:js');
    return redirect(route('login'));
});
