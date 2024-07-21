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
                @if (auth()->user()->role == -1)
                    <a class="nav-link" onclick="myFunction1()" href="#">Create A New Admin</a>
                @endif
                <a class="nav-link" onclick="myFunction2()" href="#">All Admins</a>
                <a class="nav-link" onclick="myFunction3()" href="#">Approve Trainers</a>
                <a class="nav-link" onclick="myFunction4()" href="#">All Members</a>
                <a class="nav-link" onclick="myFunction5()" href="#">All Trainers</a>
                <a class="nav-link" onclick="myFunction6()" href="#">All Bookings</a>
                <a class="nav-link" onclick="myFunction7()" href="#">Rejected Trainers</a>
            </nav>

            <hr>

            <div id="myAccount" class="row mt-3">
                <h3 class="text-center fw-bold p-4 m-2"><i>My Admin Account</i></h3>
                
                <div class="col-5 text-center align-content-center mb-5">
                    <img src="{{ asset('default_avatar/default_avatar.png') }}"  class="img-fluid w-50" alt="Duskfitness">
                </div>
                <div class="col-7 align-content-center">
                    {{-- check if there is a currently logged in user --}}
                    @if(auth()->user())
                        {{-- Show the user their details --}}
                        <h5 class="p-3"><strong><i>First Name:</i></strong> {{auth()->user()->firstname}}  </h5>
                        <h5 class="p-3"><strong><i>Last Name:</i></strong> {{auth()->user()->lastname}} </h5>
                        <h5 class="p-3"><strong><i>Address:</i></strong> {{auth()->user()->address}} ss</h5>
                        <h5 class="p-3"><strong><i>Email:</i></strong> {{auth()->user()->email}} </h5>
                        <h5 class="p-3"><strong><i>Phone:</i></strong> 0{{auth()->user()->phone}} </h5>
                        @if(auth()->user()->role == 0)
                            <h5 class="p-3"><strong><i>Level:</i></strong> I am a Normal Admin </h5>
                        @elseif(auth()->user()->role == -1)
                            <h5 class="p-3"><strong><i>Level:</i></strong> I am a Super Admin </h5>
                        @endif
                    @else
                        
                    @endif
        
                    <div class="text-center m-4">
                        {{--  --}}
                        <a href="{{ url('edit/'.auth()->user()->id) }}" class="btn btn-outline-primary m-2" >
                            Edit Details
                        </a>
                        {{--  --}}
                        <a href="{{ url('delete/'.auth()->user()->id) }}" onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" class="btn btn-outline-danger m-2">
                            Delete Account
                        </a>
                    </div>
                </div>
            </div>

            <div id="newAdmin" class="row" style="display: none">
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    Create New Admin 
                </h3>
                
                <div class="container-fluid w-50">
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
                        <form class="form-group" action="{{ route('new_admin.post',  ['adminID'=>auth()->user()->id]) }}" method="POST">
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

                            <div class="col-12 form-check form-switch p-3">
                                <input class="form-check-input fs-4 ms-3" type="checkbox" name="super_admin">
                                <label class="form-check-label p-1 ms-3" for="super_admin">
                                    Make this User a Super Admin?
                                </label>
                                  
                                {{-- <input type="radio" name='super_admin' value="Make this User a Super Admin?">
                                <label for="super_admin"></label> --}}
                            </div>

                            <div class="col-12 p-3 border border-bottom border-top" style="background-color: #DCDCDC">
                                <h6> <strong> The Password Must: </strong> </h6>
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
                                    <button class="form-control w-25 btn btn-outline-success">Create New Admin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>                
            </div>

            <div id="admins" class="row mt-3" style="display: none">
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    View All Admins 
                </h3>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center fw-bold">
                            <th scope="col">Admin FirstName</th>
                            <th scope="col">Admin LastName</th>
                            <th scope="col">Admin Address</th>
                            <th scope="col">Admin Phone Number</th>
                            <th scope="col">Admin Email Address</th>
                            <th scope="col">Account Status</th>
                            <th scope="col">Admin Level</th>
                            @if (auth()->user()->role == -1)
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allAdmins as $admin)
                            <tr class="text-center">
                                <td scope="row" class="p-4"> {{ $admin -> firstname }} </td>
                                <td class="p-4"> {{ $admin -> lastname }} </td>
                                <td class="p-4"> {{ $admin -> address }} </td>
                                <td class="p-4"> 0{{ $admin -> phone }} </td>
                                <td class="p-4"> {{ $admin -> email }} </td>
                                <td class="p-4"> {{ $admin -> status }} </td>
                                @if ($admin->role == -1)
                                    <td class="p-4"> SuperAdmin </td>
                                @else
                                    <td class="p-4"> Normal Admin </td>
                                @endif

                                @if (auth()->user()->id != $admin->id)
                                    @if (auth()->user()->role == -1)
                                        <td class="p-4">
                                            @if($admin -> status == 'suspended')
                                                <a href=" {{ url('admin/'.auth()->user()->id.'/reactivate-admin/'.$admin->id) }} ">
                                                    <button class="btn btn-outline-success"> Re-Activate Admin </button>
                                                </a>
                                            @else
                                                <a href=" {{ url('admin/'.auth()->user()->id.'/suspend-admin/'.$admin->id) }} ">
                                                    <button class="btn btn-outline-success"> Suspend Admin </button>
                                                </a>
                                            @endif
                                            
                                            <a href=" {{ url('admin/'.auth()->user()->id.'/delete-admin/'.$admin->id) }} " onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false">
                                                <button class="btn btn-outline-danger"> Delete Admin </button>
                                            </a>
                                        </td>
                                    @endif
                                @endif 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="approveTrainers" class="row mt-3" style="display: none;">
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    Approve Trainers 
                </h3>
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
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    View All Members 
                </h3>
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
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    View All Trainers 
                </h3>
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
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    View All Bookings 
                </h3>
                <div class="d-flex">
                    <div class="col-5">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center fw-bold">
                                    <th scope="col">Member Name</th>
                                    <th scope="col">Member Email</th>
                                    <th scope="col">Member Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allMemberBookings as $member_booking)
                                    <tr class="text-center">
                                        <td scope="row" class="p-4"> {{ $member_booking -> firstname }} {{ $member_booking -> lastname }} </td>
                                        <td class="p-4"> {{ $member_booking -> email }} </td>
                                        <td class="p-4"> 0{{ $member_booking -> phone }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-1">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center fw-bold">
                                    <th scope="col">Has Booked</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allMemberBookings as $member_booking)
                                    <tr class="text-center">
                                        <td class="p-4"> -> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center fw-bold">
                                    <th scope="col">Trainer Name</th>
                                    <th scope="col">Trainer Email</th>
                                    <th scope="col">Trainer Phone</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allTrainerBookings as $trainer_booking)
                                    <tr class="text-center">
                                        <td scope="row" class="p-4"> {{ $trainer_booking -> firstname }} {{ $trainer_booking -> lastname }} </td>
                                        <td class="p-4"> {{ $trainer_booking -> email }} </td>
                                        <td class="p-4"> 0{{ $trainer_booking -> phone }} </td>
                                        <td> 
                                            <a href=" {{ url('admin/'.auth()->user()->id.'/remove-booking/'.$trainer_booking->id) }} " onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false">
                                                <button class="btn btn-outline-danger"> Cancel Booking </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="rejected" class="row mt-3" style="display: none;">
                <h3 class="text-center fw-bold fst-italic" id="Title">
                    View All Rejected Trainers 
                </h3>
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
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'block';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction1(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'block';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction2(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'block';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction3(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'block';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction4(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'block';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction5(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'block';
        bookings.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction6(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'block';
        rejected.style.display = 'none';
    }

    function myFunction7(){
        var myAcc = document.getElementById("myAccount");
        var newAdmin = document.getElementById("newAdmin");
        var admins = document.getElementById("admins");
        var approvals = document.getElementById("approveTrainers");
        var members = document.getElementById("members");
        var trainers = document.getElementById("trainers");
        var bookings = document.getElementById("bookings");
        var rejected = document.getElementById("rejected");

        myAcc.style.display = 'none';
        newAdmin.style.display = 'none';
        admins.style.display = 'none';
        approvals.style.display = 'none';
        members.style.display = 'none';
        trainers.style.display = 'none';
        bookings.style.display = 'none';
        rejected.style.display = 'block';
    }
</script>

@endsection