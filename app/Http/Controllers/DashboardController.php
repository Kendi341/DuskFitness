<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{    
    function toDashboard(){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // we need to check if the logged in user has booked any trainers
        // if not, we just show them their dashboard
        // if so, we let them see their trainers
        $has_bookings = false;

        // check if the user's ID appears in the bookings table
        $check_for_bookings = DB::table('bookings')
        -> select('user_id')
        -> where('user_id', '=', auth()->user()->id);

        // if it does appear, it means the user has a booking, so we show them
        if($check_for_bookings){
            $has_bookings = true;

            // select the trainer's name, time and day at which the user has booked
            $booked_trainer = DB::table('users')
                ->distinct()
                ->join('bookings', function($join){
                    $join->on('users.id', '=', 'bookings.trainer_id');
                    $join->on('users.id' , '=', 'users.id');
                })
                ->select('users.*', 'bookings.day', 'bookings.time')
                ->get();
        }

        // if it is a trainer who has logged in
        if (auth()->user()->role == 1){
            // get all the trainer's trainees
            $trainees = DB::table('users')
                ->distinct()
                ->join('bookings', function($join){
                    $join->on('users.id', '=', 'bookings.user_id');
                    $join->on('users.id' , '=', 'users.id');
                })
                ->select('users.*', 'bookings.day', 'bookings.time')
                ->get();
            
                $has_bookings = true;
                // dd($booked_trainer);
            
                // takes us to the dashboard page
                $trainers = User::where('role','like','1') -> get();
                return view('/dashboard', compact('trainers', 'trainees', 'has_bookings'));
        }

        // takes us to the dashboard page
        $trainers = User::where('role','like','1') -> get();
        return view('/dashboard', compact('trainers', 'has_bookings', 'booked_trainer'));
    }
    
    // takes us to the edit details page
    // we pass th user ID to the view
    function edit($id){
        $user = User::find($id);
        return view('editDetails', compact('user'));
    }

    // to delete the specific user
    function destroy($id){
        $user = User::find($id);
        $user->delete();
        return redirect('home')->with('success', 'Account Successfully Deleted!');
    }

    function bookTrainer($user_id, $trainer_id){
        $user = User::find($user_id);
        $trainer = User::find($trainer_id);

        return view('book', compact('user', 'trainer'));
    }
}
