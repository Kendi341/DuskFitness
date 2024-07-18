<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    function toAdminPage($adminID){
        // if user is not logged in, redirect to the login page
        if (!auth()->user()) {
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        if (auth()->user()->role != 0) {
            return redirect('home')->with('danger', 'You are NOT AUTHORIZED to access this page!');
        }

        $pendingTrainers = DB::select('select * from users where approval = ?', ['no']);
        $allAdmins = DB::select('select * from users where role = ?', [0]);
        $allMembers = DB::select('select * from users where role = ?', [2]);
        $allTrainers = DB::select('select * from users where role = ?', [1]);
        $allBookings = DB::table('users')
        ->join('bookings', 'bookings.trainer_id', '=', 'users.id')
        ->join('bookings as b', 'b.user_id', '=', 'users.id')
        ->select('users.*', 'bookings.*')
        ->get();
        $rejectedTrainers = DB::select('select * from users where approval = ?', ['never']);

        return view('admindash', compact('pendingTrainers', 'allAdmins' , 'allMembers', 'allTrainers', 'allBookings', 'rejectedTrainers'));

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
}
