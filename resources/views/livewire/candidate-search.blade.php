<div class="container">
    <div class="row">
        {{-- <div class="col-lg-4">
            <div class="latest-job-left br-10 px-40 bg-color-light">
                <div class="form-group mb-md-4 mb-3">
                    <div class="d-flex flex-wrap mb-3 justify-content-between">
                        <label for="" class="fs-16 text-secondary my-auto pb-2">
                            {{ __('web.web_jobs.search_by_keywords') }}</label>
                        <button wire:click="resetFilter()" class="btn btn-sm btn-primary reset-filter text-nowrap mb-2"
                            id="btnReset">{{ __('web.reset_filter') }}</button>
                    </div>
                    <input class="form-control fs-14 text-gray bg-white br-10 p-3"
                        wire:model.debounce.100ms="searchByCandidate" type="search" id="searchByCandidate"
                        autocomplete="off" placeholder="@lang('web.common.search')">
                </div>
                <div class="form-group mb-md-4 mb-3 ">
                    <label for="" class="fs-16 text-secondary mb-3">
                        {{ __('web.common.location') }}</label>
                    <input class="form-control fs-14 text-gray bg-white br-10 p-3 search-by-location" type="search"
                        autocomplete="off" placeholder="@lang('web.web_jobSeeker.search_by_location')" name="min" wire:model="location">
                </div>
                <div class="form-group mb-md-4 mb-3 ">
                    <label for="" class="fs-16 text-secondary mb-3">
                        {{ __('messages.candidate.expected_salary') }}</label>
                    <input class="form-control fs-14 text-gray bg-white br-10 p-3" type="text" placeholder="Min"
                        name="min" wire:model="min" autocomplete="off">
                    <input class="form-control fs-14 text-gray bg-white br-10 p-3 mt-2" type="text" placeholder="Max"
                        name="max" wire:model="max" autocomplete="off">
                </div>
                <div class="form-group mb-md-4 mb-3 ">
                    <label for="" class="fs-16 text-secondary mb-3">
                        {{ __('messages.candidate.gender') }}</label>
                    <ul>
                        <li>
                            <input type="radio" name="gender" id="All" value="all"
                                wire:click="changeFilter('gender','all')" wire:model="gender">
                            <label for="All" class="ms-1 my-1"><span
                                    class=""></span>{{ __('messages.common.all') }}</label>
                        </li>
                        <li>
                            <input type="radio" name="gender" id="Male" value="male"
                                wire:click="changeFilter('gender','male')" wire:model="gender">
                            <label for="Male" class="ms-1 my-1"><span
                                    class=""></span>{{ __('messages.common.male') }}</label>
                        </li>
                        <li>
                            <input type="radio" name="gender" id="Female" value="female"
                                wire:click="changeFilter('gender','female')" wire:model="gender">
                            <label for="Female" class="ms-1 my-1"><span
                                    class=""></span>{{ __('messages.common.female') }}
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4 px-lg-3">
            <div class="latest-job-left br-10 px-40 bg-light mb-40">
                <form>
                    <div class="form-group mb-md-4 mb-3 ">
                        <div class="d-flex flex-wrap mb-3 justify-content-between">
                            <label for=""
                                class="fs-16 text-secondary mb-3">{{ __('web.web_jobs.search_by_keywords') }}</label>
                            <button wire:click.prevent="resetFilter()" class="btn btn-sm btn-primary  reset-filter text-nowrap mb-2 px-3 py-1"
                            id="btnReset">{{ __('web.reset_filter') }}</button>
                        </div>
                        <input class="form-control fs-14 text-gray bg-white br-10 p-3"
                            wire:model.debounce.100ms.live="searchByCandidate" type="search" id="searchByCandidate"
                            autocomplete="off" placeholder="@lang('web.common.search')">
                    </div>
                    <div class="form-group mb-md-4 mb-3 ">
                        <label for="" class="fs-16 text-secondary mb-3">
                            {{ __('web.common.location') }}</label>
                        <input class="form-control fs-14 text-gray bg-white br-10 p-3 search-by-location" type="search"
                            autocomplete="off" placeholder="@lang('web.web_jobSeeker.search_by_location')" name="min" wire:model.live="location">
                    </div>
                    <div class="form-group mb-md-4 mb-3 ">
                        <label for="" class="fs-16 text-secondary mb-3">
                            {{ __('messages.candidate.expected_salary') }}</label>
                        <input class="form-control fs-14 text-gray bg-white br-10 p-3" type="text" placeholder="@lang('web.home_menu.min')"
                            name="min" wire:model.live="min" autocomplete="off">
                        <input class="form-control fs-14 text-gray bg-white br-10 p-3 mt-2" type="text"
                            placeholder="@lang('web.home_menu.max')" name="max" wire:model.live="max" autocomplete="off">
                    </div>
                    <div class="form-group mb-md-4 mb-3 ">
                        <label for="" class="fs-16 text-secondary mb-3">
                            {{ __('messages.candidate.gender') }}</label>
                        <ul class="p-0">
                            <li>
                                <input type="radio" name="gender" id="All" value="all"
                                    wire:click="changeFilter('gender','all')" wire:model="gender">
                                <label for="All" class="ms-1 my-1"><span
                                        class=""></span>{{ __('messages.common.all') }}</label>
                            </li>
                            <li>
                                <input type="radio" name="gender" id="Male" value="male"
                                    wire:click="changeFilter('gender','male')" wire:model="gender">
                                <label for="Male" class="ms-1 my-1"><span
                                        class=""></span>{{ __('messages.common.male') }}</label>
                            </li>
                            <li>
                                <input type="radio" name="gender" id="Female" value="female"
                                    wire:click="changeFilter('gender','female')" wire:model="gender">
                                <label for="Female" class="ms-1 my-1"><span
                                        class=""></span>{{ __('messages.common.female') }}
                                </label>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="content-column col-lg-8 col-md-12 col-sm-12">
            <div class="row">
                @forelse($candidates as $candidate)
                    <div class="col-lg-6 col-md-6 px-xl-3 mb-40">
                        <div class="card py-30">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img src="{{ $candidate->candidate_url }}" class="card-img" alt="">
                                </div>
                                <div class="col-10 px-3">
                                    <div class="card-body p-0">
                                        <a href="{{ route('front.candidate.details', $candidate->unique_id) }}"
                                            class="text-secondary primary-link-hover">
                                            <h5 class="card-title   fs-20 mb-0">
                                                {{ $candidate->user->full_name }}</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex">
                                                                               @if (!empty($candidate->industry))
                                                                                   <div class="desc d-flex mb-2">
                                                                                       <i class="fa-solid fa-briefcase text-gray me-3 fs-18"></i>
                                                                                       <p class="fs-14 text-gray mb-0">{{$candidate->industry->name}}</p>
                                                                                   </div>
                                                                               @endif
                                        @if (!empty($candidate->full_location) || !empty($candidate->location2))
                                            <div class="desc location-text d-flex">
                                                <i class="fa-solid fa-location-dot  me-1 mt-1 fs-18"></i>
                                                <span class="">
                                                    {{ isset($candidate->full_location) ? html_entity_decode(Str::limit($candidate->full_location, 10, '...')) : __('messages.common.n/a') }}{{ isset($candidate->location2) ? ',' . html_entity_decode(Str::limit($candidate->location2, 10, '...')) : '' }}</span>
                                            </div>
                                        @endif
                                        @if (!empty($candidate->expected_salary))
                                            <span><i class="fa-solid fa-money-bill-alt text-gray ms-3 me-2"></i></span>
                                            <p class="fs-14 text-gray mb-0">{{ $candidate->expected_salary }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-desc mt-3">
                                    <div class="desc  d-flex mt-2">
                                        <a href="{{ route('front.candidate.details', $candidate->unique_id) }}"
                                            class="jobs-position  fs-14 mb-0 me-3">
                                            {{ __('web.web_jobSeeker.view_profile') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            @if ($candidates->count() > 0)
                {{ $candidates->links() }}
            @endif
        </div> --}}

        <div class="content-column col-lg-8 px-lg-3">
            <div class="job-card">
                @forelse($candidates as $candidate)
                    <div class=" mb-40">
                        <div class="card py-30 border-0 ">
                            <div class="d-sm-flex position-relative">
                                <div class="mb-sm-0 mb-3 {{ getFrontSelectLanguage() == 'ar' ? 'ms-sm-4' : 'me-sm-4' }}">
                                    <img src="{{ asset('img_template/test-job.png') }}" class="card-img" alt="...">
                                </div>
                                <div class="">
                                    <div class="card-body p-0 ">
                                        <a href="{{ route('front.candidate.details', $candidate->unique_id) }}"
                                            class="text-secondary primary-link-hover">
                                            <h5 class="card-title text-secondary fs-18 mb-0">{{ $candidate->user->full_name }}
                                            </h5>
                                        </a>
                                        <div class="">
                                            <div class="card-desc d-flex flex-wrap mt-2 ">
                                                {{-- <div class="desc d-flex  me-4">
                                                    <div class="me-3 w-20">
                                                        <img src="{{ asset('img_template/briefcase.svg') }}"
                                                            class="w-100">
                                                    </div>
                                                    <p class="fs-14 text-gray mb-2">Agricultural Inspectors</p>
                                                </div> --}}
                                                @if (!empty($candidate->full_location) || !empty($candidate->location2))
                                                    <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                            <img src="{{ asset('img_template/location.svg') }}"
                                                                class="w-100">
                                                        </div>
                                                        <p class="fs-14 text-gray mb-2">
                                                            {{ isset($candidate->full_location) ? html_entity_decode(Str::limit($candidate->full_location, 10, '...')) : __('messages.n/a') }}{{ isset($candidate->location2) ? ',' . html_entity_decode(Str::limit($candidate->location2, 10, '...')) : '' }}
                                                        </p>
                                                    </div>
                                                @endif
                                                @if (!empty($candidate->expected_salary))
                                                    <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                            <img src="{{ asset('img_template/money.svg') }}"
                                                                class="w-100" />
                                                        </div>
                                                        <p class="fs-14 text-gray mb-2">
                                                            {{ $candidate->expected_salary }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="desc d-flex flex-wrap pt-2">
                                            <a href="{{ route('front.candidate.details', $candidate->unique_id) }}"
                                                class="text text-primary mb-0 me-3">
                                                {{ __('web.web_jobSeeker.view_profile') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 text-center text-gray">
                        @lang('web.job_menu.no_results_found')
                    </div>
                @endforelse
            </div>
            @if ($candidates->count() > 0)
                {{ $candidates->links() }}
            @endif
        </div>
    </div>
</div>
