{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <ul class="j-error-padding list-unstyled p-2 mb-0">--}}
{{--            <li class="text-white">{{ $errors->first() }}</li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}

@if(!empty($errors))
    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <div class="d-flex">
                    <span class="mt-1"><i class="fa-solid fa-face-frown me-1"></i></span>
                    <span class="mt-1">&nbsp{{$errors->first()}}</span>
                </div>
            </div>
        </div>
    @endif
@endif
