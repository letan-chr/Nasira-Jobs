@if ($errors->any())
    <div class="alert alert-danger">
        <div>
            <div class="d-flex">
                <span class="mt-1"><i class="fa-solid fa-face-frown"></i></span>
                <span class="mt-1 ms-2">&nbsp{{$errors->first()}}</span>
            </div>
        </div>
    </div>
@endif
