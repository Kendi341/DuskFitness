@extends('layouts.app')

@section('content')

<h3 class="text-center fw-bold p-4" id="Title">
    BOOK TRAINER
</h3>

<h4 class="text-center fw-semibold fst-italic p-4" id="Title">
    TRAINER NAME: {{$trainer->firstname}} <span> </span> {{$trainer->lastname}}
</h4>

<div class="container-fluid w-50">
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

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <form class="form-group" action="{{ url('processing-booking/'.$user->id.'/'.$trainer->id) }}" method="POST">
            <!-- csrf is a security feature for laravel -->
            @csrf
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="text" name="fname" placeholder="Trainer First Name" value="{{ $trainer->firstname }}" disabled style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="text" name="lname" placeholder="Trainer Last Name" value="{{ $trainer->lastname }}" disabled style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="text" name="address" placeholder="Trainer Address" value="{{ $trainer->address }}" disabled style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="email" name="email" placeholder="Trainer Email" value="{{ $trainer->firstname }}" disabled style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="date" name="date" id="date" onfocus="disablePastDates()" placeholder="Pick a date" style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="time" name="time" id="time" placeholder="Pick a time" style="width: 500px">
            </div>

            <div class="row justify-content-center">
                <button type="submit" class="form-control w-25 btn btn-outline-success mb-3">Book Trainer</button>
            </div>

        </form>

    </div>
    
</div>
@endsection
<script>
    function disablePastDates() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('min', today);
    }
</script>
