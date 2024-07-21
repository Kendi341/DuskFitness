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

        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role > 2) {
            return redirect('home')->with('danger', 'You are NOT AUTHORIZED to access this page!');
        }

        $pendingTrainers = DB::select('select * from users where approval = ?', ['no']);
        $allAdmins = DB::select('select * from users where role = ? or role = ?', [0, -1]);
        $allMembers = DB::select('select * from users where role = ?', [2]);
        $allTrainers = DB::select('select * from users where role = ?', [1]);
        $allTrainerBookings = DB::table('users')
        ->join('bookings', 'bookings.trainer_id', '=', 'users.id')
        // ->join('bookings as b', 'b.user_id', '=', 'users.id')
        ->select('users.firstname', 'users.lastname', 'users.email', 'users.phone', 'bookings.*')
        ->get();
        $allMemberBookings = DB::table('users')
        //->join('bookings', 'bookings.trainer_id', '=', 'users.id')
        ->join('bookings', 'bookings.user_id', '=', 'users.id')
        ->select('users.*', 'bookings.*')
        ->get();
        $rejectedTrainers = DB::select('select * from users where approval = ?', ['never']);

        return view('admindash', compact('pendingTrainers', 'allAdmins' , 'allMembers', 'allTrainers', 'allTrainerBookings', 'allMemberBookings', 'rejectedTrainers'));
    }

    function createNewAdmin(Request $request, $adminID){
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

        if ($request->super_admin == "on") {
            $data['role'] = -1;
        } else {
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

        // dd($request->super_admin);
        

        // insert the user in the database
        // we use a model
        // a model does all the queries to the database
        // the below creates a user by passing in to the model all the items which the user has inputted
        $user = User::create($data);

        // check if user creation is successful
        // if there is no user
        if (!$user){
            return redirect('admin/'.$adminID)->with('error', 'Registration failed, try again!');
        } 

        return redirect('admin/'.$adminID)->with('success', 'New Admin Successfully Created!');
    }

    function suspendAdmin($adminID, $admin_ID){
        User::where('id', $admin_ID)->update(['status' => 'suspended']);

        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Suspended!');
    }

    function reactivateAdmin($adminID, $admin_ID){
        User::where('id', $admin_ID)->update(['status' => 'active']);

        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Re-Activated!');
    }

    function deleteAdmin($adminID, $admin_ID){
        $admin = User::find($admin_ID);

        $admin->delete();

        return redirect('admin/'.$adminID)->with('success', 'Admin has been Successfully Deleted!');
    }

    function approveTrainers($adminID, $trainerID){

        User::where('id', $trainerID)->update(['approval' => 'yes', 'status' => 'active']);

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Approved!'); 
    }

    function rejectTrainers($adminID, $trainerID) {
        User::where('id', $trainerID)->update(['approval' => 'never', 'status' => 'inactive']);

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Rejected!'); 

    }

    function suspendMembers($adminID, $memberID) {
        User::where('id', $memberID)->update(['status' => 'suspended']);

        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Suspended!');
    }
    
    function reactivateMembers($adminID, $memberID) {
        User::where('id', $memberID)->update(['status' => 'active']);

        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Re-Activated!');
    }

    function deleteMembers($adminID, $memberID) {
        $member = User::find($memberID);
        $member_bookings = Booking::where('user_id','like',$memberID);

        $member->delete();
        $member_bookings->delete();

        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Deleted!');
    }

    function suspendTrainers($adminID, $trainerID){
        User::where('id', $trainerID)->update(['status' => 'suspended']);

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Suspended!');
    }

    function reactivateTrainers($adminID, $trainerID){
        User::where('id', $trainerID)->update(['status' => 'active']);

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Re-Activated!');
    }

    function deleteTrainers($adminID, $trainerID){
        $trainer = User::find($trainerID);
        $trainer_bookings = Booking::where('user_id','like',$trainerID);

        $trainer->delete();
        $trainer_bookings->delete();

        return redirect('admin/'.$adminID)->with('success', 'Member has been Successfully Deleted!');
    }

    function reapproveTrainer($adminID, $trainerID){
        User::where('id', $trainerID)->update(['status' => 'active', 'approval' => 'yes']);

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Successfully Re-Approved!');
    }

    function removeTrainer($adminID, $trainerID){
        $trainer = User::find($trainerID);
        $trainer_bookings = Booking::where('user_id','like',$trainerID);

        $trainer->delete();
        $trainer_bookings->delete();

        return redirect('admin/'.$adminID)->with('success', 'Trainer has been Permanently Deleted!');
    }

    function removeBooking($adminID, $bookingID){
        // find the booking
        $booking = Booking::find($bookingID);

        // delete it
        $booking->delete();

        return redirect('admin/'.$adminID)->with('success', 'Booking has been Permanently Deleted!');
    }
}
