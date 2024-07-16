@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
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
                        <h5 class="p-3">First Name: Admin Fname </h5>
                        <h5 class="p-3">Last Name: Admin Lname</h5>
                        <h5 class="p-3">Address: Admin Address</h5>
                        <h5 class="p-3">Email: Admin Email</h5>
                        <h5 class="p-3">Phone: Admin Phone Number</h5>
                        @if(auth()->user()->role == 0)
                            <h5 class="p-3">Admin Firstname</h5>
                        @elseif(auth()->user()->role == 2)
                            <h5 class="p-3">I am a Gym Member</h5>
                        @endif
                    @else
                        
                    @endif
        
                    <div class="text-center m-4">
                        {{-- href="{{ url('edit/'.auth()->user()->id) }} --}}
                        <a class="btn btn-outline-primary m-2" >
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
                
            </div>

            <div id="members" class="row mt-3" style="display: none;">
                <h2>ALL MEMBERS</h2>
            </div>

            <div id="trainers" class="row mt-3" style="display: none;">
                <h2>ALL TRAINERS</h2>
            </div>

            <div id="bookings" class="row mt-3" style="display: none;">
                <h2>ALL BOOKINGS</h2>
            </div>

            <div id="rejected" class="row mt-3" style="display: none;">
                <h2>REJECTIONS</h2>
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