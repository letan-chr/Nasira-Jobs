<div class="container px-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="row d-flex justify-content-center mb-5 mt-4">
                @if(Request::segment(1) =='admin')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block admin-login">Super Admin Login</a></div>
                @elseif(Request::segment(2) =='candidate-login')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block candidate-login">Candidate Login</a></div>
                @elseif(Request::segment(2) =='employee-login')
                    <div class="col-lg-6 mt-2">
                        <a class="btn btn-primary d-block employee-login">Employee Login</a></div>
                @endif
                <div class="col-lg-6 mt-2">
                    <a href="{{url('/')}}" class="btn
                        btn-info d-block front-site">Front Site</a>                 
                </div>
            </div>
        </div>
    </div>
</div>
