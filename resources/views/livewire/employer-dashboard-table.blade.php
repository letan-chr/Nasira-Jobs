<div class="content flex-column-fluid">
    <div class="container-fluid container-xxl">
        <div class="row">
            <!--begin::Col-->
            <div class="col-xl-6 {{ checkLanguageSession() == 'ar' ? 'pe-0' : 'ps-0' }}">
                <!--begin::Tables Widget 1-->
                <div class="mb-xl-8">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between border-0 pt-5">
                        <h3 class="align-items-start flex-column">
                            <span class="fs-3 mb-1">{{ __('messages.employer_menu.recent_jobs') }}</span>
                        </h3>
                        <!--begin::Menu-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                        <span>
                            <a href="{{ route('job.index') }}"
                                class="btn btn-info">{{ __('messages.common.view_more') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Menu-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="py-3">
                        <!--begin::Table container-->
                        <div class="table-responsive ">
                            <!--begin::Table-->
                            <table class="table table-striped align-middle gs-0 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="{{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} text-muted  fs-7 text-uppercase gs-0">
                                        <th class="">{{ __('messages.job.job_title') }}</th>
                                        <th class="">{{ __('messages.employer_menu.expires_on') }}</th>
                                        <th class="text-center">{{ __('messages.common.status') }}</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold">
                                    @if (count($recentJobs) > 0)
                                        @foreach ($recentJobs as $recentJob)
                                            <tr>
                                                <td class="ps-3">
                                                    <a href="{{ route('front.job.details', $recentJob->job_id) }}"
                                                        class="text-decoration-none"
                                                        >{{ html_entity_decode($recentJob->job_title) }}</a>
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($recentJob->job_expiry_date)->translatedFormat('jS M, Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <div
                                                        class="badge w-auto bg-{{ \App\Models\Job::STATUS_COLOR[$recentJob->status] }}">
                                                            @php
                                                                $status = \App\Models\Job::STATUS[$recentJob->status];
                                                            @endphp
                                                            <span>{{ getTranslatedData($status)[0] }}</span>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                </div>
                <!--endW::Tables Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-xl-6 {{ checkLanguageSession() == 'ar' ? 'ps-0' : 'pe-0' }}">
                <!--begin::Tables Widget 1-->
                <div class="mb-xl-8">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between border-0 pt-5">
                        <h3 class="align-items-start flex-column">
                            <span class=" fs-3 mb-1">{{ __('messages.employer_menu.recent_follower') }}</span>
                        </h3>
                        <!--begin::Menu-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                        <span>
                            <a href="{{ route('followers.index') }}"
                                class="btn btn-info">{{ __('messages.common.view_more') }} <i
                                    class="fas fa-chevron-right"></i></a>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Menu-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="py-3">
                        <!--begin::Table container-->
                        <div class="table-responsive ">
                            <!--begin::Table-->
                            <table class="table table-striped align-middle gs-0 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="{{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} text-muted fs-7 text-uppercase gs-0">
                                        <th class="">{{ __('messages.company.candidate_name') }}</th>
                                        <th class="">{{ __('messages.company.candidate_phone') }}</th>
                                        <th class=" text-center">{{ __('messages.company.candidate_email') }}</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600">
                                    @if (count($recentFollowers) > 0)
                                        @foreach ($recentFollowers as $recentFollower)
                                            <tr>
                                                <td class="ps-3">
                                                    {{ html_entity_decode($recentFollower->user->full_name) }}
                                                </td>
                                                <td>
                                                    {{ empty($recentFollower->user->phone) ? __('messages.n/a') : $recentFollower->user->phone }}
                                                </td>
                                                <td class="{{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                                                    {{ $recentFollower->user->email }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <span>{{ __('messages.employer_menu.no_data_available') }}.</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                </div>
                <!--endW::Tables Widget 1-->
            </div>

        </div>
    </div>
</div>
