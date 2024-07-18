@extends('layouts.app')

@section('content')

<div class="container-fluid">
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
        <div class="col-12">
            <nav class="nav nav-pills nav-fill">
                <a class="nav-link active" onclick="myFunction()" aria-current="page" href="#">My Account Details</a>
                <a class="nav-link" onclick="myFunction1()" href="#">Approve Trainers</a>
                <a class="nav-link" onclick="myFunction2()" href="#">All Members</a>
                <a class="nav-link" onclick="myFunction3()" href="#">All Trainers</a>
                <a class="nav-link" onclick="myFunction4()" href="#">All Bookings</a>
                <a class="nav-link" onclick="myFunction5()" href="#">Rejected Trainers</a>
            </nav>

            <div id="myAccount" class="row mt-3">
                <h5 class="text-center fw-bold p-4 m-2">MY ACCOUNT</h5>
                
                <div class="col-4 text-center align-content-center mb-5">
                    <img src="{{ asset('default_avatar/default_avatar.png') }}"  class="img-fluid w-50" alt="Duskfitness">
                </div>
                <div class="col-8">
                    {{-- check if there is a currently logged in user --}}
                    @if(auth()->user())
                        {{-- Show the user their details --}}
                        <h5 class="p-3">First Name: {{auth()->user()->firstname}}  </h5>
                        <h5 class="p-3">Last Name: {{auth()->user()->lastname}} </h5>
                        <h5 class="p-3">Address: {{auth()->user()->address}} ss</h5>
                        <h5 class="p-3">Email: {{auth()->user()->email}} </h5>
                        <h5 class="p-3">Phone: 0{{auth()->user()->phone}} </h5>
                        @if(auth()->user()->role == 0)
                            <h5 class="p-3">Admin Firstname</h5>
                        @elseif(auth()->user()->role == 2)
                            <h5 class="p-3">I am a Gym Member</h5>
                        @endif
                    @else
                        
                    @endif
        
                    <div class="text-center m-4">
                        {{--  --}}
                        <a href="{{ url('edit/'.auth()->user()->id) }} class="btn btn-outline-primary m-2" >
                            Edit Details
                        </a>
                        {{-- href="{{ url('delete/'.auth()->user()->id) }}" --}}
                        <a onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" class="btn btn-outline-danger m-2">
                            Delete Account
                        </a>
                    </div>
                </div>
            </div>

            <div id="approveTrainers" class="row mt-3" style="display: none;">
                <h2>APPROVE TRAINERS</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Approval Status</th>
                            <th scope="col">Account Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingTrainers as $pendingTrainer)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $pendingTrainer -> firstname }} </td>
                                <td class="p-4"> {{ $pendingTrainer -> lastname }} </td>
                                <td class="p-4"> {{ $pendingTrainer -> address }} </td>
                                <td class="p-4"> 0{{ $pendingTrainer -> phone }} </td>
                                <td class="p-4"> {{ $pendingTrainer -> email }} </td>
                                <td class="p-4"> {{ $pendingTrainer -> approval }} </td>
                                <td class="p-4"> {{ $pendingTrainer -> status }} </td>
                                <td class="p-4"> 
                                    <a href=" {{ url('admin/'.auth()->user()->id.'/approve/'.$pendingTrainer->id) }} ">
                                        <button class="btn btn-outline-success"> Approve Trainer </button>
                                    </a>
                                    <a href=" {{ url('admin/'.auth()->user()->id.'/reject/'.$pendingTrainer->id) }} ">
                                        <button class="btn btn-outline-danger"> Reject Trainer </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="members" class="row mt-3" style="display: none;">
                <h2>ALL MEMBERS</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Account Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allMembers as $member)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $member -> firstname }} </td>
                                <td class="p-4"> {{ $member -> lastname }} </td>
                                <td class="p-4"> {{ $member -> address }} </td>
                                <td class="p-4"> 0{{ $member -> phone }} </td>
                                <td class="p-4"> {{ $member -> email }} </td>
                                <td class="p-4"> {{ $member -> status }} </td>
                                <td class="p-4">
                                    @if ($member->status == 'active')
                                        <a href=" {{ url('admin/'.auth()->user()->id.'/suspend-member/'.$member->id) }} ">
                                            <button class="btn btn-outline-primary"> Suspend Member </button>
                                        </a>
                                    @else
                                        <a href=" {{ url('admin/'.auth()->user()->id.'/reactivate-member/'.$member->id) }} ">
                                            <button class="btn btn-outline-primary"> Reactivate Member </button>
                                        </a>
                                    @endif
                                    
                                    <a href=" {{ url('admin/'.auth()->user()->id.'/delete-member/'.$member->id) }} " onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false">
                                        <button class="btn btn-outline-danger"> Delete Member </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="trainers" class="row mt-3" style="display: none;">
                <h2>ALL TRAINERS</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Account Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allTrainers as $trainer)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $trainer -> firstname }} </td>
                                <td class="p-4"> {{ $trainer -> lastname }} </td>
                                <td class="p-4"> {{ $trainer -> address }} </td>
                                <td class="p-4"> 0{{ $trainer -> phone }} </td>
                                <td class="p-4"> {{ $trainer -> email }} </td>
                                <td class="p-4"> {{ $trainer -> status }} </td>
                                <td class="p-4">
                                    @if ($trainer->status == 'active')
                                        <a href=" {{ url('admin/'.auth()->user()->id.'/suspend-trainer/'.$trainer->id) }} ">
                                            <button class="btn btn-outline-primary"> Suspend Trainer </button>
                                        </a>
                                    @else
                                        <a href=" {{ url('admin/'.auth()->user()->id.'/reactivate-trainer/'.$trainer->id) }} ">
                                            <button class="btn btn-outline-primary"> Reactivate Trainer </button>
                                        </a>
                                    @endif

                                    <a href=" {{ url('admin/'.auth()->user()->id.'/delete-trainer/'.$trainer->id) }} " onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false">
                                        <button class="btn btn-outline-danger"> Delete Trainer </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="bookings" class="row mt-3" style="display: none;">
                <h2>ALL BOOKINGS</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">Booking FirstName</th>
                            <th scope="col">Trainer LastName</th>
                            <th scope="col">Trainer Address</th>
                            <th scope="col">Trainer Phone Number</th>
                            <th scope="col">Trainer Email Address</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allBookings as $booking)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $booking -> firstname }} </td>
                                <td class="p-4"> {{ $booking -> lastname }} </td>
                                <td class="p-4"> {{ $booking -> address }} </td>
                                <td class="p-4"> 0{{ $booking -> phone }} </td>
                                <td class="p-4"> {{ $booking -> day }} </td>
                                <td class="p-4"> 
                                    {{-- <a href=" {{ url('book-trainer/'.auth()->user()->id.'/'.$trainer->id) }} "> --}}
                                        <button class="btn btn-outline-success"> Approve Trainer </button>
                                        <button class="btn btn-outline-danger"> Reject Trainer </button>
                                    {{-- </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="rejected" class="row mt-3" style="display: none;">
                <h2>REJECTIONS</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Account Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejectedTrainers as $rejectedTrainer)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $rejectedTrainer -> firstname }} </td>
                                <td class="p-4"> {{ $rejectedTrainer -> lastname }} </td>
                                <td class="p-4"> {{ $rejectedTrainer -> address }} </td>
                                <td class="p-4"> 0{{ $rejectedTrainer -> phone }} </td>
                                <td class="p-4"> {{ $rejectedTrainer -> email }} </td>
                                <td class="p-4"> {{ $rejectedTrainer -> status }} </td>
                                <td class="p-4"> 
                                    <a href=" {{ url('admin/'.auth()->user()->id.'/reapprove-trainer/'.$rejectedTrainer->id) }} ">
                                        <button class="btn btn-outline-success"> Re-Approve Trainer </button>
                                    </a>
                                    <a href=" {{ url('admin/'.auth()->user()->id.'/remove-trainer/'.$rejectedTrainer->id) }} " onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false">
                                        <button class="btn btn-outline-danger"> Delete Trainer Account </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const navLinkEls = document.querySelectorAll('.nav-link');

    navLinkEls.forEach(navLinkEls => {
        navLinkEls.addEventListener('click', () => {
            document.querySelector('.active')?.classList.remove('active');            
            navLinkEls.classList.add('active');
        });
    });

    function myFunction(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'block';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction1(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        approvals.style.display = 'block';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction2(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'block';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction3(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'block';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction4(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'block';
        rejected.style.display = 'none';
    }

    function myFunction5(){
        var myAcc = document.getElementById("myAccount");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'block';
    }
</script>

@endsection