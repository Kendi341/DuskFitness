@extends('layouts.app')

@section('title') Reset Password @endsection

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

        <form class="form-group" action="{{ route('resetpassword.post', $userID) }}" method="POST">
            <!-- csrf is a security feature for laravel forms -->
            @csrf
            <div class="col-12 p-3 border border-bottom border-top" style="background-color: #DCDCDC">
                <h6> <strong> Your Password Must: </strong> </h6>
                <ul> 
                    <li> Contain at least 8 characters </li> 
                    <li> Contain at least 1 lowercase character </li>
                    <li> Contain at least 1 uppercase character </li>
                    <li> Contain at least 1 special character </li>
                </ul>
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="password" name="new_password" placeholder="Enter New Password" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password" style="width: 500px">
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