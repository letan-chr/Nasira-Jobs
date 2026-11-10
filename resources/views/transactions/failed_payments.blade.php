@extends('employer.layouts.app')
@section('title')
    Payment Failed
@endsection 
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="card shadow-danger">
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between flex-wrap">
                            <div class="col-12 text-danger m-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0">{{ __('messages.flash.payment_failed_try_again') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <a class="btn btn-primary" href="{{ route('manage-subscription.index') }}">{{ __('messages.see_all_plans') }}</a>
            </div>
        </div>
    </section>
@endsection
