@extends('layouts.app')

@section('title') Trainer Register @endsection

@section('content')

<h3 class="text-center fw-bold p-4" id="Title">
    <i>REGISTER AS A TRAINER<i>
</h3>

<div class="container-fluid w-50 border p-5">
    <div class="row justify-content-center">
        <div class="mt-5">
            @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <form class="form-group" action="{{ route('trainer.register.post') }}" method="POST">
            <!-- csrf is a security feature for laravel -->
            @csrf
            <div class="col-12 text-center p-3">
                <input class="form-control" type="text" name='fname' placeholder="Enter First Name" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="text" name='lname' placeholder="Enter Last Name" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="text" name='address' placeholder="Enter Address" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="number" name='phone' placeholder="Enter Phone Number e.g 7xxxxxxxx" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="text" name='email' placeholder="Enter Email Address" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="number" name='no_of_trainees' placeholder="Enter the Number of Trainees You Would Like to Train Per Day" style="width: 500px">
            </div>
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
                <input class="form-control" type="password" name='password' placeholder="Enter Password" style="width: 500px">
            </div>
            <div class="col-12 text-center p-3">
                <input class="form-control" type="password" name='confirm_password' placeholder="Confirm Password" style="width: 500px">
            </div>

            <div class="row justify-content-center">
                <div class="text-center m-5">
                    <h5 class="mb-4"> Already have an account? Click <a class="text-decoration-none" href="{{ route('trainer.login') }}" style="color: #FF1493"> here</a> to sign in </h5>
                    <button class="form-control w-25 btn btn-outline-success">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
    
</div>

@endsection

