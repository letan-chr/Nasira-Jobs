<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('name', __('messages.company.employer_name').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ html_entity_decode($company->user->first_name) }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('email',__('messages.company.email').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->email }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('phone', __('messages.user.phone').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->user->phone) ? $company->user->phone:__('messages.n/a') }}</s>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('ceo',__('messages.company.employer_ceo').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800"> {{ !empty($company->ceo)?html_entity_decode($company->ceo):__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('industry_id', __('messages.company.industry').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->industry->name)?$company->industry->name : __('messages.n/a')}}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('ownership_type_id', __('messages.company.ownership_type').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->ownerShipType->name)?$company->ownerShipType->name: __('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('company_size_id',__('messages.company.company_size').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->companySize->size)?$company->companySize->size: __('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('established_in',  __('messages.company.established_in').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->established_in)?$company->established_in: __('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('location', __('messages.company.location').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->location)?html_entity_decode($company->location) : __('messages.n/a')}}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('country', __('messages.company.country').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->user->country_id) ?$company->user->country_name:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('state',  __('messages.company.state').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->user->state_id) ?$company->user->state_name:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('city',__('messages.company.city').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->user->city_id) ? $company->user->city_name:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('no_of_offices', __('messages.company.no_of_offices').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->no_of_offices!=null ?$company->no_of_offices:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('fax',  __('messages.company.fax').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->fax!=null ?$company->fax:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('website', __('messages.company.website').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ !empty($company->website)?$company->website:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('is_active', __('messages.common.status').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->is_active == 1 ? __('messages.common.active') : __('messages.common.de_active') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('is_featured', __('messages.company.is_featured').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ ($company->activeFeatured)  ? __('messages.common.yes') : __('messages.common.no') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('facebook_url', __('messages.company.facebook_url').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->facebook_url!=null?$company->user->facebook_url:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('twitter_url', __('messages.company.twitter_url').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->twitter_url!=null ?$company->user->twitter_url:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('linkedin_url',__('messages.company.linkedin_url').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <p class="fs-5 text-gray-800">{{ $company->user->linkedin_url!=null ?$company->user->linkedin_url:__('messages.n/a') }}</p>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('google_plus_url', __('messages.company.google_plus_url').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->google_plus_url!=null ?$company->user->google_plus_url:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('pinterest_url', __('messages.company.pinterest_url').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800">{{ $company->user->pinterest_url!=null ? $company->user->pinterest_url:__('messages.n/a') }}</span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('created_at',__('messages.common.created_on').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                                           title="{{ date('jS M, Y', strtotime($company->created_at)) }}">{{ $company->created_at->diffForHumans() }}</span>
        </span>
</div>
<div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
    {{ Form::label('updated_at',__('messages.common.last_updated').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <span class="fs-5 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                                           title="{{ date('jS M, Y', strtotime($company->updated_at)) }}">{{ $company->updated_at->diffForHumans() }}</span>
        </span>
</div>
<div class="form-group col-sm-12 col-md-12 col-xl-6">
    {{ Form::label('company_logo', __('messages.company.company_logo').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
    <br>
    <div class="image image-lg-small">
        <img id='logoPreview' class="testimonial-modal-img"
             src="{{ (!empty($company->user->media[0])) ? $company->user->media[0]->getFullUrl() : asset('assets/img/infyom-logo.png') }}">
    </div>
    </div>
    <div class="form-group col-xl-6 col-md-12 col-sm-12">
        {{ Form::label('details', __('messages.company.employer_details').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <b><span class="m-0">{!! isset($company->details) ? nl2br($company->details) : __('messages.n/a') !!}</span>
        </b>
    </div>
