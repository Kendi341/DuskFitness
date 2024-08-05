@extends('layouts.app')

@section('title') Dashboard @endsection

@section('content')

<h3 class="text-center fw-bold p-4" id="Title">
    <i>My Dashboard Page</i> 
</h3>

<div class="container">
    <div class="row justify-content-center">
        <!-- Here, we print out the errors 
            -- this first section prints out errors due to form validation (the validate function in Dashboard Controller)
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

        <!-- Here, we print out the errors due to the users attempt to book
              -- this section connects with the -> with method in BookingController
              -- they are many, so we foreach to print each one of them out
            -->
        @if(session()->has('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
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
        <div class="col-4 text-center align-content-center mb-5">
            <img src="{{ asset('default_avatar/default_avatar.png') }}"  class="img-fluid w-50" alt="Duskfitness">
        </div>
        <div class="col-8">
            {{-- check if there is a currently logged in user --}}
            @if(auth()->user())
                {{-- Show the user their details --}}
                <h5 class="p-3"><strong><i>First Name: </i></strong> {{auth()->user()->firstname}}</h5>
                <h5 class="p-3"><strong><i>Last Name: </i></strong> {{auth()->user()->lastname}}</h5>
                <h5 class="p-3"><strong><i>Address: </i></strong> {{auth()->user()->address}}</h5>
                <h5 class="p-3"><strong><i>Email: </i></strong> {{auth()->user()->email}}</h5>
                @if(auth()->user()->role == 1)
                    <h5 class="p-3"><strong><i>Role: </strong>I am a Trainer</h5>
                @elseif(auth()->user()->role == 2)
                    <h5 class="p-3"><strong><i>Role: </i></strong>I am a Gym Member</h5>
                @endif

            @else
                
            @endif

            <div class="text-center m-4">
                <a class="btn btn-outline-primary m-2" href="{{ url('edit/'.auth()->user()->id) }}">
                    Edit Details
                </a>
                <a onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" class="btn btn-outline-danger m-2" href="{{ url('delete/'.auth()->user()->id) }}">
                    Delete Account
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs nav-justified">
                @if(auth()->user()->role == 1)
                    <li class="nav-item">
                        <a id="underMe" class="nav-link active" onclick="myFunction()" aria-current="page" href="#">Gym Trainers</a>
                    </li>
                    <li class="nav-item">
                        <a id="mySchedule" class="nav-link" onclick="myFunction2()" href="#">My Schedule</a>
                    </li>
                @elseif(auth()->user()->role == 2)
                    <li class="nav-item">
                        <a id="browseTrainers" class="nav-link active" onclick="myFunction3()" aria-current="page" href="#">Browse Trainers</a>
                    </li>
                    <li class="nav-item">
                        <a id="bookings" class="nav-link" onclick="myFunction4()" href="#">My Bookings</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    @if (auth()->user()->role == 2)
        <div id="browser" class="row mt-3">
            <h5 class="text-center fw-bold p-4 m-2"><i>Book A Trainer Below</i></h5>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center fw-bold">
                        <th scope="col">Trainer FirstName</th>
                        <th scope="col">Trainer LastName</th>
                        <th scope="col">Trainer Address</th>
                        <th scope="col">Trainer Phone Number</th>
                        <th scope="col">Trainer Email Address</th>
                        @if (auth()->user()->role == 2)
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainers as $trainer)
                        <tr class="text-center">
                            <td scope="row" class="p-4"> {{ $trainer -> firstname }} </td>
                            <td class="p-4"> {{ $trainer -> lastname }} </td>
                            <td class="p-4"> {{ $trainer -> address }} </td>
                            <td class="p-4"> 0{{ $trainer -> phone }} </td>
                            <td class="p-4"> {{ $trainer -> email }} </td>
                            @if (auth()->user()->role == 2)
                            <td class="p-4"> 
                                <a href=" {{ url('book-trainer/'.auth()->user()->id.'/'.$trainer->id) }} ">
                                    <button class="btn btn-outline-primary"> Book Trainer </button>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="books" class="row mt-3" style="display: none;">
            <h5 class="text-center fw-bold p-4 m-2"><i>Trainers I Have Booked</i></h5>

            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center fw-bold">
                        <th scope="col">Trainer FirstName</th>
                        <th scope="col">Trainer LastName</th>
                        <th scope="col">Trainer Address</th>
                        <th scope="col">Trainer Phone Number</th>
                        <th scope="col">Trainer Email Address</th>
                        <th scope="col">Date of Reservation</th>
                        <th scope="col">Time of Reservation</th>
                    </tr>
                </thead>
                <tbody>
                    @if($has_bookings)
                        @foreach ($booked_trainers as $booked_trainer)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $booked_trainer -> firstname }} </td>
                                <td class="p-4"> {{ $booked_trainer -> lastname }} </td>
                                <td class="p-4"> {{ $booked_trainer -> address }} </td>
                                <td class="p-4"> {{ $booked_trainer -> email }} </td>
                                <td class="p-4"> 0{{ $booked_trainer -> phone }} </td>
                                <td class="p-4"> {{ $booked_trainer -> day }} </td>
                                <td class="p-4"> {{ $booked_trainer -> time }} </td>
                                <td class="p-4"> 
                                    <a href="{{ url('cancel-booking/'.$booked_trainer->id) }}">
                                        <button class="btn btn-outline-danger"> Cancel Booking </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach                    
                    @endif
                </tbody>
            </table>
        </div>

    @elseif (auth()->user()->role == 1)
        <div id="browser" class="row mt-3">
            <h5 class="text-center fw-bold p-4 m-2"><i>Trainers at the Gym</i></h5>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center fw-bold">
                        <th scope="col">Trainer FirstName</th>
                        <th scope="col">Trainer LastName</th>
                        <th scope="col">Trainer Address</th>
                        <th scope="col">Trainer Email Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainers as $trainer)
                        <tr class="text-center">
                            <td scope="row" class="p-4"> {{ $trainer -> firstname }} </td>
                            <td class="p-4"> {{ $trainer -> lastname }} </td>
                            <td class="p-4"> {{ $trainer -> address }} </td>
                            <td class="p-4"> {{ $trainer -> email }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="books" class="row mt-3" style="display: none;">
            <h5 class="text-center fw-bold p-4 m-2"><i>My Trainees</i></h5>
                
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center fw-bold">
                        <th scope="col">Member FirstName</th>
                        <th scope="col">Member LastName</th>
                        <th scope="col">Member Address</th>
                        <th scope="col">Member Email Address</th>
                        <th scope="col">Date of Reservation</th>
                        <th scope="col">Time of Reservation</th>
                    </tr>
                </thead>
                <tbody>
                    @if($has_bookings)
                        @foreach ($trainees as $trainee)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $trainee -> firstname }} </td>
                                <td class="p-4"> {{ $trainee -> lastname }} </td>
                                <td class="p-4"> {{ $trainee -> address }} </td>
                                <td class="p-4"> {{ $trainee -> email }} </td>
                                <td class="p-4"> {{ $trainee -> day }} </td>
                                <td class="p-4"> {{ $trainee -> time }} </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    @endif
@endsection

<script>
    function myFunction() {
        var element = document.getElementById("underMe");
        var element2 = document.getElementById("mySchedule");
        element.classList.add("active");
        element2.classList.remove("active");

        var trainers = document.getElementById("browser")
        var books = document.getElementById("books");
        trainers.style.display = 'block';
        books.style.display = 'none';
    }
    
    function myFunction2() {
        var element = document.getElementById("underMe");
        var element2 = document.getElementById("mySchedule");
        element.classList.remove("active");
        element2.classList.add("active");

        var trainers = document.getElementById("browser");
        var books = document.getElementById("books");
        trainers.style.display = 'none';
        books.style.display = 'block';
    }
    function myFunction3() {
        var element = document.getElementById("browseTrainers");
        var element2 = document.getElementById("bookings");
        element.classList.add("active");
        element2.classList.remove("active");

        var trainers = document.getElementById("browser")
        var books = document.getElementById("books");
        trainers.style.display = 'block';
        books.style.display = 'none';
    }
    function myFunction4() {
        var element = document.getElementById("browseTrainers");
        var element2 = document.getElementById("bookings");
        element.classList.remove("active");
        element2.classList.add("active");

        var trainers = document.getElementById("browser");
        var books = document.getElementById("books");
        trainers.style.display = 'none';
        books.style.display = 'block';
    }
</script>