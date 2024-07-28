<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    function toAdminPage($adminID){
        // if user is not logged in, redirect to the login page
        if (!auth()->user()) {
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // if a member or trainer tries to acces this page, redirect to login with error
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role > 2) {
            return redirect('home')->with('danger', 'You are NOT AUTHORIZED to access this page!');
        }

        // get all trainers whose status is 'no'
        $pendingTrainers = DB::select('select * from users where approval = ?', ['no']);

        // get all admins (0 - normal admin) (-1 - superadmin)
        $allAdmins = DB::select('select * from users where role = ? or role = ?', [0, -1]);

        // get all members (role = 2)
        $allMembers = DB::select('select * from users where role = ?', [2]);

        // get all trainers (role = 1)
        $allTrainers = DB::select('select * from users where role = ?', [1]);

        // get all members that have booked trainers
        $allTrainerBookings = DB::table('users')
        ->join('bookings', 'bookings.trainer_id', '=', 'users.id')
        ->select('users.firstname', 'users.lastname', 'users.email', 'users.phone', 'bookings.*')
        ->get();

        // get all trainers that have been booked by members
        $allMemberBookings = DB::table('users')
        ->join('bookings', 'bookings.user_id', '=', 'users.id')
        ->select('users.*', 'bookings.*')
        ->get();

        // get all trainers whose approval status is 'never'
        $rejectedTrainers = DB::select('select * from users where approval = ?', ['never']);

        // to admin dashboard page
        return view('admindash', compact('pendingTrainers', 'allAdmins' , 'allMembers', 'allTrainers', 'allTrainerBookings', 'allMemberBookings', 'rejectedTrainers'));
    }

    // create a new admin
    function createNewAdmin(Request $request, $adminID) {

        // validating the request as we did in login
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*#?&]/'],
            'confirm_password' => 'required'
        ]);
        
        // get data from the request variable and store it in an array 
        // e.g. gets the fname from the request variable and stores in the data array
        $data['firstname'] = $request->fname;
        $data['lastname'] = $request->lname;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['password'] = $request->password;

        // check if the admin has turned on the toggle that makes the new admin a superadmin
        if ($request->super_admin == "on") {

            // make a superadmin
            $data['role'] = -1;
        } else {

            // make a normal admin
            $data['role'] = 0;
        }

        $data['status'] = 'active';
        $data2['confirm_password'] = $request->confirm_password;

        // check if passwords match
        if ($data['password'] != $data2['confirm_password']){
            return redirect('admin/'.$adminID)->with('danger', 'Passwords do not Match!');
        }

        // encrypt the password
        $data['password'] = Hash::make($request->password);        

        // insert the admin in the database
        // we use a model
        // a model does all the queries to the database
        // the below creates a user by passing in to the model all the items which the user has inputted
        $user = User::create($data);

        // check if admin creation is successful
        // if there is no user
        if (!$user){
            return redirect('admin/'.$adminID)->with('error', 'Registration failed, try again!');
        } 

        // back to admin dashboard with succcess message
        return redirect('admin/'.$adminID)->with('success', 'New Admin Successfully Created!');
    }

    // suspend an admin's account
    function suspendAdmin($adminID, $admin_ID){
        // find the admin and change status to 'suspended'
        User::where('id', $admin_ID)->update(['status' => 'suspended']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Suspended!');
    }

    // 'un-suspend' an admin
    function reactivateAdmin($adminID, $admin_ID){
        // find the admin and change status to 'active'
        User::where('id', $admin_ID)->update(['status' => 'active']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Re-Activated!');
    }

    // remove an admin account from the db
    function deleteAdmin($adminID, $admin_ID){
        // find the admin using the ID
        $admin = User::find($admin_ID);

        // delete from the db
        $admin->delete();

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Deleted!');
    }

    // approve trainers
    function approveTrainers($adminID, $trainerID){
        // find trainer via the ID and update the following:
        // approval = yes -> trainer account is now active
        // status = active -> trainer is now able to access their account
        User::where('id', $trainerID)->update(['approval' => 'yes', 'status' => 'active']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Approved!'); 
    }

    // reject trainers
    function rejectTrainers($adminID, $trainerID) {
        // find the trainer via ID and update the following:
        // approval = never -> trainer has been rejected
        // status = inactive -> trainer account is not accessible
        User::where('id', $trainerID)->update(['approval' => 'never', 'status' => 'inactive']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Rejected!'); 
    }

    // suspend member accounts
    function suspendMembers($adminID, $memberID) {
        // find member via ID and update status to 'suspended
        User::where('id', $memberID)->update(['status' => 'suspended']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Suspended!');
    }

    // 'un-suspend' member account
    function reactivateMembers($adminID, $memberID) {
        // find member via ID and change status to 'active'
        User::where('id', $memberID)->update(['status' => 'active']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Re-Activated!');
    }

    // delete member account
    function deleteMembers($adminID, $memberID) {

        // find member via ID
        $member = User::find($memberID);

        // find member's bookings
        $member_bookings = Booking::where('user_id','like',$memberID);

        // delete the member's user account
        $member->delete();

        // delete any bookings the member has made
        $member_bookings->delete();

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Deleted!');
    }

    // suspend trainer accounts
    function suspendTrainers($adminID, $trainerID){
        // find the trainer via their ID and change status to 'suspended'
        User::where('id', $trainerID)->update(['status' => 'suspended']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Suspended!');
    }

    // 'un-suspend' trainer account
    function reactivateTrainers($adminID, $trainerID){
        // find trainer via ID and change status to 'active'
        User::where('id', $trainerID)->update(['status' => 'active']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Re-Activated!');
    }

    // delete trainer account
    function deleteTrainers($adminID, $trainerID){
        // find trainer via ID
        $trainer = User::find($trainerID);

        // find bookings associated with the trainer
        $trainer_bookings = Booking::where('user_id','like',$trainerID);

        // delete the trainer's user account
        $trainer->delete();

        // delete the bookings associated with the trainer
        $trainer_bookings->delete();

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Deleted!');
    }

    // 'un-reject' trainer
    function reapproveTrainer($adminID, $trainerID){
        // find trainer via ID and change the following:
        // status = active -> trainer has access to the account
        // approval = yes -> trainer account is now accessible
        User::where('id', $trainerID)->update(['status' => 'active', 'approval' => 'yes']);

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Re-Approved!');
    }

    // delete rejected trainer's account
    function removeTrainer($adminID, $trainerID) {
        // find trainer via ID
        $trainer = User::find($trainerID);

        // find bookings assiciated with trainer
        $trainer_bookings = Booking::where('user_id','like',$trainerID);

        // delete trainer account
        $trainer->delete();

        // delete bookings associated with trainers
        $trainer_bookings->delete();

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Permanently Deleted!');
    }

    // remove a booking
    function removeBooking($adminID, $bookingID){
        // find the booking via it's ID
        $booking = Booking::find($bookingID);

        // delete it
        $booking->delete();

        // back to admin dashboard woth success message
        return redirect('admin/'.$adminID)->with('success', 'Booking has been Permanently Deleted!');
    }
}
