<div class="ms-auto" wire:ignore>
         <div class="dropdown d-flex align-items-center {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} me-md-2">
             <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
                 id="companiesFilterBtn"data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                 <p class="text-center">
                     <i class='fas fa-filter'></i>
                 </p>
             </button>
             <div class="dropdown-menu py-0" aria-labelledby="companiesFilterBtn">
                 <div class="text-start border-bottom py-4 px-7">
                     <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                 </div>
                 <div class="p-5">
                       <div class="mb-5">
                                <label for="filterBtn" class="form-label">{{ __('messages.filter_name.featured_company') }}:</label>
                                {{ Form::select('featured',getTranslatedData(collect($filterHeads[0])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2 abc', 'data-control' => 'select2', 'id' => 'featuredCompany']) }}
                       </div>
                     <div class="mb-5">
                                <label for="filterBtn" class="form-label">{{__('messages.common.status')}}:</label>
                                {{ Form::select('employee_status', getTranslatedData(collect($filterHeads[1])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2', 'data-control'=>"select2", 'id' => 'companyStatus']) }}
                            </div>
                     <div class="d-flex justify-content-end">
                         <button type="reset" class="btn btn-secondary"
                             id="company-ResetFilter">{{ __('messages.common.reset') }}</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
