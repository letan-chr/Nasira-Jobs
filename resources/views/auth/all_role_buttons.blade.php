<div class="container px-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="row d-flex justify-content-center mb-5 mt-4">
                @if(Request::segment(1) =='admin')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block admin-login">{{ __('web.super_admin_login') }}</a></div>
                @elseif(Request::segment(2) =='candidate-login')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block candidate-login">{{ __('web.candidate_login') }}</a></div>
                @elseif(Request::segment(2) =='employee-login')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block employee-login">{{ __('web.employer_login') }}</a></div>
                @endif
                <div class="col-lg-6 mt-2">
                    <a href="{{url('/')}}" class="btn
                        btn-info d-block front-site">{{ __('messages.front_site') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
