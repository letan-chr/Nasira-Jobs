const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copy('resources/assets/js/currency.js', 'public/js/currency.js')
mix.js('resources/js/app.js', 'public/js').vue()
mix.copy('node_modules/slick-carousel/slick/fonts', 'public/assets/css/fonts')
mix.copy('node_modules/slick-carousel/slick/ajax-loader.gif',
    'public/assets/css/ajax-loader.gif')

// front subscribe News-letter
mix.js('resources/assets/js/web/js/news_letter/news_letter.js',
    'public/assets/js/web/js/news_letter/news_letter.js')
// mix.js('resources/assets/js/livewire-turbo.js',
//     'public/assets/js/livewire-turbo.js')

// third-party css
mix.styles([
    'resources/theme/css/third-party.css',
    'node_modules/intl-tel-input/build/css/intlTelInput.css',

    'node_modules/timepicker/jquery.timepicker.min.css',
    'node_modules/quill/dist/quill.snow.css',
    'node_modules/quill/dist/quill.bubble.css',
], 'public/assets/css/third-party.css')

// light theme css
mix.styles('resources/theme/css/style.css', 'public/assets/css/style.css')
mix.styles('resources/theme/css/plugins.css', 'public/css/plugins.css')
mix.styles('resources/assets/custom.css', 'public/css/custom.css')

// dark theme css
mix.styles('resources/theme/css/style.dark.css',
    'public/assets/css/style.dark.css')
mix.styles('resources/theme/css/plugins.dark.css',
    'public/css/plugins.dark.css')

//custom css
mix.sass('resources/assets/sass/new-custom.scss',
    'public/assets/css/custom.css')
mix.sass('resources/assets/sass/new-custom-dark.scss',
    'public/assets/css/custom-dark.css')
mix.sass('resources/assets/sass/custom-auth.scss',
    'public/assets/css/custom-auth.css').version()

mix.copyDirectory('node_modules/intl-tel-input/build/img',
    'public/assets/img')
mix.copyDirectory('resources/assets/img', 'public/assets/img')
mix.copyDirectory('resources/theme/images', 'public/images')
mix.copyDirectory('resources/theme/webfonts', 'public/assets/webfonts')
mix.copyDirectory('resources/theme/fonts', 'public/fonts')

// backend custom js
mix.js([
    // 'resources/assets/js/turbo.js',
    'resources/assets/js/custom/helpers.js',
    'resources/assets/js/custom/custom.js',
    'resources/assets/js/pending_jobs/pending_jobs.js',
    'resources/assets/js/job_categories/job_categories.js',
    'resources/assets/js/settings/settings.js',
    'resources/assets/js/company_sizes/company_sizes.js',
    'resources/assets/js/marital_status/marital_status.js',
    'resources/assets/js/salary_periods/salary_periods.js',
    'resources/assets/js/job_shifts/job_shifts.js',
    'resources/assets/js/industries/industries.js',
    'resources/assets/js/job_tags/job_tags.js',
    'resources/assets/js/job_types/job_types.js',
    'resources/assets/js/ownership_types/ownership_types.js',
    'resources/assets/js/companies/companies.js',
    'resources/assets/js/companies/create-edit.js',
    'resources/assets/js/languages/languages.js',
    'resources/assets/js/required_degree_levels/required_degree_levels.js',
    'resources/assets/js/functional_areas/functional_areas.js',
    'resources/assets/js/career_levels/career_levels.js',
    'resources/assets/js/user_profile/user_profile.js',
    'resources/assets/js/employer_profile/employer_profile.js',
    'resources/assets/js/salary_currencies/salary_currencies.js',
    'resources/assets/js/jobs/create-edit.js',
    'resources/assets/js/jobs/jobs.js',
    'resources/assets/js/jobs/job_datatable_admin.js',
    'resources/assets/js/candidate/create-edit.js',
    'resources/assets/js/custom/input_price_format.js',
    'resources/assets/js/custom/state_country.js',
    'resources/assets/js/candidates/candidate-profile/candidate-resume.js',
    'resources/assets/js/candidates/candidate-profile/candidate-education-experience.js',
    'resources/assets/js/candidates/candidate-profile/cv-builder.js',
    'resources/assets/js/candidate/candidate-list.js',
    'resources/assets/js/admins/admin-list.js',
    'resources/assets/js/job_applications/job_applications.js',
    'resources/assets/js/custom/currency.js',
    'resources/assets/js/currency.js',
    'resources/assets/js/candidates/candidate-profile/candidate_career_informations.js',
    'resources/assets/js/candidates/candidate-profile/candidate-general.js',
    'resources/assets/js/testimonial/testimonial.js',
    'resources/assets/js/candidate/favourite_jobs.js',
    'resources/assets/js/jobs/reported_jobs.js',
    'resources/assets/js/companies/front/company-details.js',
    'resources/assets/js/candidate/favourite_company.js',
    'resources/assets/js/companies/front/reported_companies.js',
    'resources/assets/js/companies/front/companies.js',
    'resources/assets/js/candidate_profile/candidate_profile.js',
    'resources/assets/js/candidate/applied-jobs.js',
    'resources/assets/js/skills/skills.js',
    'resources/assets/js/roles/roles.js',
    'resources/assets/js/noticeboards/noticeboards.js',
    'resources/assets/js/subscribers/subscribers.js',
    'resources/assets/js/faqs/faqs.js',
    'resources/assets/js/blog_categories/blog_categories.js',
    'resources/assets/js/blogs/blogs.js',
    'resources/assets/js/blogs/create-edit.js',
    'resources/assets/js/inquires/inquires.js',
    'resources/assets/js/sidebar_menu_search/sidebar_menu_search.js',
    'resources/assets/js/candidate/reported_candidates.js',
    'resources/assets/js/candidate/front/candidate-details.js',
    'resources/assets/js/plans/plans.js',
    'resources/assets/js/subscription/subscription.js',
    'resources/assets/js/transactions/transactions.js',
    'resources/assets/js/jobs/jobs_stripe_payment.js',
    'resources/assets/js/companies/companies_stripe_payment.js',
    'resources/assets/js/custom/phone-number-country-code.js',
    'resources/assets/js/employer_transactions/transactions.js',
    'resources/assets/js/image_slider/image_slider.js',
    'resources/assets/js/header_sliders/header_sliders.js',
    'resources/assets/js/privacy_policy/privacy_policy.js',
    'resources/assets/js/branding_sliders/branding_sliders.js',
    'resources/assets/js/home/home.js',
    'resources/assets/js/employer/dashboard.js',
    'resources/assets/js/employer/follower.js',
    'resources/assets/js/countries/countries.js',
    'resources/assets/js/states/states.js',
    'resources/assets/js/cities/cities.js',
    'resources/assets/js/jobs/job_notification.js',
    'resources/assets/js/language_translate/language_translate.js',
    'resources/assets/js/candidate/resumes.js',
    'resources/assets/js/dashboard/admin-dashboard.js',
    'resources/assets/js/email_templates/email_templates.js',
    'resources/assets/js/email_templates/create-edit.js',
    'resources/assets/js/selected_candidate/selected_candidate.js',
    'resources/assets/js/job_stages/job_stages.js',
    'resources/assets/js/job_applications/job_slots.js',
    'resources/assets/js/job_expired/job_expired.js',
    'resources/assets/js/post_comments/post_comments.js',
    'resources/assets/js/front_cms/front_cms_setting.js',
], 'public/js/pages.js').version()

// // third-party js
mix.scripts([
    'resources/theme/js/vendor.js',
    'resources/theme/js/plugins.js',
    'node_modules/chart.js/dist/Chart.js',
    'node_modules/intl-tel-input/build/js/intlTelInput.js',
    'node_modules/intl-tel-input/build/js/utils.js',
    'node_modules/autonumeric/dist/autoNumeric.min.js',
    'node_modules/quill/dist/quill.js',
    'public/messages.js',
    'resources/assets/js/html2pdf.bundle.min.js',
], 'public/js/third-party.js').version()

// front-third-party css
mix.styles([

    'node_modules/intl-tel-input/build/css/intlTelInput.css',
    'node_modules/ion-rangeslider/css/ion.rangeSlider.min.css',
    'node_modules/select2/dist/css/select2.min.css',
    'node_modules/sweetalert/dist/sweetalert.css',
    'node_modules/toastr/build/toastr.min.css',

    'node_modules/slick-carousel/slick/slick.css',
    'node_modules/slick-carousel/slick/slick-theme.css',

], 'public/assets/css/front-third-party.css')

// front-pages css
mix.styles([
    'resources/assets/front_web_css/about-us.css',
    'resources/assets/front_web_css/blog.css',
    'resources/assets/front_web_css/bootstrap.css',
    'resources/assets/front_web_css/company-details.css',
    'resources/assets/front_web_css/contact-us.css',
    'resources/assets/front_web_css/custom.css',
    'resources/assets/front_web_css/home.css',
    'resources/assets/front_web_css/job-details.css',
    'resources/assets/front_web_css/layout.css',
    'resources/assets/front_web_css/slick-theme.css',
    'resources/assets/front_web_css/slick.css',

], 'public/css/front-pages.css')

// front-third-party js
mix.scripts([
    'public/messages.js',
    'public/front_web/js/bootstrap.bundle.min.js',
    'public/front_web/js/jquery.min.js',

    'node_modules/@fortawesome/fontawesome-free/js/all.min.js',
    'node_modules/izitoast/dist/js/iziToast.min.js',
    'node_modules/moment/min/moment.min.js',
    'public/front_web/js/jquery-ui.min.js',
    'public/front_web/js/slick.min.js',

    'node_modules/intl-tel-input/build/js/intlTelInput.js',
    'node_modules/intl-tel-input/build/js/utils.js',
    'node_modules/ion-rangeslider/js/ion.rangeSlider.min.js',
    'node_modules/select2/dist/js/select2.min.js',
    'node_modules/sweetalert/dist/sweetalert.min.js',
    'node_modules/toastr/build/toastr.min.js',
], 'public/js/front-third-party.js').version()

// auth third party
mix.scripts([
    'resources/theme/js/vendor.js',
    'resources/theme/js/plugins.js',
    'resources/assets/js/custom/helpers.js',
    'resources/assets/js/auto_fill/admin_login.js',
], 'public/js/auth-third-party.js').version()

//front page js
mix.js([
    // 'resources/assets/js/turbo.js',
    'resources/assets/js/custom/helpers.js',
    // 'resources/assets/js/custom/custom.js',
    'resources/assets/js/home/home.js',
    'resources/assets/js/front_register/front_register.js',
    'resources/assets/js/front_register/google-recaptcha.js',
    'resources/assets/js/auto_fill/auto_fill.js',

    'resources/assets/js/web/front_settings/front_settings.js',
    'resources/assets/js/web/js/news_letter/news_letter.js',
    'resources/assets/js/web/js/blog/blog_comments.js',
    'resources/assets/js/jobs/front/job_search.js',
    'resources/assets/js/jobs/front/apply_job.js',
    'resources/assets/js/jobs/front/job_details.js',
    'resources/assets/js/candidate/front/candidate-details.js',
    'resources/assets/js/companies/front/company-details.js',
    'resources/assets/js/companies/front/reported_companies.js',
    'resources/assets/js/companies/front/companies.js',
    'resources/assets/js/web/js/custom/web_custom.js',
    'resources/assets/js/custom/input_price_format.js',
    'resources/assets/js/custom/phone-number-country-code.js',
    'resources/assets/front_web_js/slick.min.js',

], 'public/js/front_pages.js').version()

//for front side start
mix.copy('node_modules/izitoast/dist/css/iziToast.min.css',
    'public/assets/css/iziToast.min.css')
mix.sass('resources/assets/sass/web_contact.scss',
    'public/assets/css/web_contact.css').version()
mix.copy('node_modules/sweetalert/dist/sweetalert.css',
    'public/assets/css/sweetalert.css')
mix.copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css',
    'public/assets/css/all.min.css')
mix.js([
    'resources/assets/js/custom/custom.js',
    'resources/assets/front_web_js/custom.js'
], 'public/assets/js/custom/custom.js')
