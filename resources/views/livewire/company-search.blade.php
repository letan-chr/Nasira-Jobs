<div>
    <section class="find-job-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-12">
                    <div class="find-job position-relative bg-white">
                        <div class="row align-items-center justify-content-around m-0">
                            <div class="col-lg-3 br-2 px-20">
                                <h3 class="fs-16 text-secondary mb-0">@lang('messages.notification.company')</h3>
                                <input type="search" class="fs-14 text-gray mb-0"
                                    wire:model.debounce.100ms.live="searchByCompany" autocomplete="off" id="searchByCompany"
                                    placeholder="@lang('web.web_company.search_company')">
                            </div>
                            <div class="col-lg-3 br-2 px-20">
                                <h3 class="fs-16 text-secondary mb-0">@lang('messages.company.location')</h3>
                                <input type="search" class="fs-14 text-gray mb-0"
                                    wire:model.debounce.100ms.live="searchByCity" id="searchByCity"
                                    placeholder="@lang('web.web_company.search_city')">
                            </div>
                            <div class="col-lg-3 br-2 px-20">
                                <h3 class="fs-16 text-secondary mb-0">@lang('messages.company.industry')</h3>
                                <input type="search" class="fs-14 text-gray mb-0"
                                    wire:model.debounce.100ms.live="searchByIndustry" id="searchByIndustry"
                                    placeholder="@lang('web.web_company.search_by_industry')">
                            </div>
                            <div class="col-xl-2 col-lg-3 text-center p-xl-1 px-20">
                                <a href="#" wire:click="resetFilter()" class="btn btn-primary  d-block pt-3 pb-3">{{ __('web.reset_filter') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="latest-job-section py-20">
        <div class="container">
            <div class="job-card">
                <div class="row">
                    @forelse($companies as $company)
                        @include('front_web.common.company_card')
                    @empty
                        <div class="col-md-12 text-center text-gray">
                            {{ __('web.companies_menu.no_company_found') }}
                        </div>
                    @endforelse
                </div>
            </div>
            @if ($companies->count() > 0)
                <div class="pagination-section pt-lg-5 pt-3">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
