@extends('layouts.app')

@section('title') Edit Your Details @endsection


@section('content')

<h3 class="text-center fw-bold p-4" id="Title">
    <i>EDIT YOUR DETAILS</i> 
</h3>

<div class="container-fluid w-50 border p-5">
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

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <form class="form-group" action="{{ url('update-data/'.$user->id) }}" method="post">
            <!-- csrf is a security feature for laravel -->
            @csrf
            @method('PUT')
            @if(auth()->user())
            @php
                $userid = auth()->user()->id;
            @endphp
                
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="text" name="uid" value="{{ $user->id }}" placeholder="User ID" disabled style="width: 500px">
                </div>
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="text" name="fname" value="{{ $user->firstname }}" placeholder="Enter First Name" style="width: 500px">
                </div>
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="text" name="lname" value="{{ $user->lastname }}" placeholder="Enter Last Name" style="width: 500px">
                </div>
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" placeholder="Enter Email Address" style="width: 500px">
                </div>
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="text" name="address" value="{{ $user->address }}" placeholder="Enter Address" style="width: 500px">
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
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="password" name="new_password" placeholder="Enter New Password" style="width: 500px">
                </div>
                <div class="col-12 text-center m-2 p-3">
                    <input class="form-control" type="password" name="conf_new_password"  placeholder="Confirm New Password" style="width: 500px">
                </div>
                
                @if (auth()->user()->role == 1)
                    <div class="col-12 text-center m-2 p-3">
                        <input class="form-control" type="text" placeholder="I am a Trainer" disabled  style="width: 500px">
                    </div>
                @elseif (auth()->user()->role == 2)
                    <div class="col-12 text-center m-2 p-3">
                        <input class="form-control" type="text" placeholder="I am a Gym Member" disabled style="width: 500px">
                    </div>
                @endif

                <div class="row justify-content-center">
                    <button type="submit" class="form-control w-25 btn btn-outline-success mb-3">Change Details</button>
                </div>
            @else
            @endif

        </form>

    </div>
    
</div>

@endsection

