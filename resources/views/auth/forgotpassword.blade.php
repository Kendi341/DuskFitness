@extends('layouts.app')

@section('title') Forgot Password @endsection

@section('content')

<h3 class="text-center fw-bold p-4">
    <i>RESET YOUR PASSWORD</i> 
</h3>

<div class="container-fluid w-50 border p-3">
    <div class="row justify-content-center">
        <div class="mt-5">
            <!-- Here, we print out the errors 
              -- this first section prints out errors due to form validation (the validate function in Auth Manager)
              -- they are many, so we foreach to print each one of them out
            -->
            @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                </div>
            @endif

            <!-- Here, we print out the errors due to the users attempt to login (to create a session)
              -- this section connects with the ->with method in Auth Manager
              -- they are many, so we foreach to print each one of them out
            -->

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session()->has('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <form class="form-group" action="{{ route('forgotpassword.post') }}" method="POST">
            <!-- csrf is a security feature for laravel forms -->
            @csrf
            <div class="col-12 text-center p-3">
                <input class="form-control" name="email" type="email" placeholder="Enter Email Address" style="width: 500px">
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