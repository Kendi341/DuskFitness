@extends('layouts.app')

@section('content')

<h3 class="text-center fw-bold p-4">
    RESET YOUR PASSWORD 
</h3>

<div class="container-fluid w-50">
    <div class="row justify-content-center">
        <form class="form-group">
            <div class="col-12 text-center p-3">
                <input class="form-control" type="password" placeholder="Enter Email Address" style="width: 500px">
            </div>
            <div class="row justify-content-center">
                <div class="text-center m-5">
                    <h5 class="mb-4"><a href="/login" class="text-decoration-none" style="color: #FF1493"> Back to Login </a> </h5>
                    <button class="form-control w-25 btn btn-outline-success">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
    
</div>


@endsection