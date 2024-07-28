<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class DashboardController extends Controller
{    
    function toDashboard(){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // we need to check if the logged in user has booked any trainers
        // if not, we just show them their dashboard
        // if so, we let them see their trainers
        $has_bookings = false;

        // check if the user's ID appears in the bookings table
        $check_for_bookings = DB::table('bookings')
            ->select('user_id')
            ->where('user_id', '=', auth()->user()->id);
        
        // if it does appear, it means the user has a booking, so we show them
        if(isEmpty($check_for_bookings)){
            $has_bookings = true;

            // select the trainer's name, time and day at which the user has booked them
            $booked_trainer = DB::table('users')
                ->distinct()
                ->join('bookings', function($join){
                    $join->on('users.id', '=', 'bookings.trainer_id');
                })
                ->select('users.*', 'bookings.day', 'bookings.time')
                ->get();
        }

        // if it is a trainer who has logged in
        if (auth()->user()->role == 1){

            // check if the trainer has any trainees
            // we use the variable from before ($has_bookings)
            if (!$has_bookings) {
                // takes us to the dashboard page
                $trainers = User::where('role','like','1') -> get();

                return view('/dashboard', compact('trainers', 'has_bookings'));
            }

            // get all the trainer's trainees
            /*
                * Here, we join both the users and the bookings table
                * We join them using the primary key in the users table (ID) and foreign key in the bookings table (user_id or trainer_id)
                * Bookings table has 2 foreign keys (user_id or trainer_id)
                * Since we want to get the USERS UNDER A TRAINER, we use the user_id as the foreign key
                * We have a currently logged in trainer...
                * ... so we join the two tables where the trainer's ID appears in the bookings table
                * this gives us the users who have booked a particular trainer
            */
            $trainees = DB::table('users')
                ->join('bookings', 'bookings.user_id', '=', 'users.id')
                ->select('users.*', 'bookings.day', 'bookings.time')
                ->where('bookings.trainer_id', '=', auth()->user()->id)
                ->get();
            
                $has_bookings = true;
            
                // get all trainers
                $trainers = User::where('role','like','1') -> get();

                // takes us to the dashboard page
                return view('/dashboard', compact('trainers', 'trainees', 'has_bookings'));
                
        } else if ((auth()->user()->role == 2)) {
            // check if the user has booked any trainers
            // we use the variable from before ($has_bookings)
            if (!$has_bookings) {
                // takes us to the dashboard page
                $trainers = User::where('role','like','1') -> get();

                return view('/dashboard', compact('trainers', 'has_bookings'));
            }

            // get all the trainers that the user has booked
            /*
                * Here, we join both the users and the bookings table
                * We join them using the primary key in the users table (ID) and foreign key in the bookings table (user_id or trainer_id)
                * Bookings table has 2 foreign keys (user_id or trainer_id)
                * Since we want to get the TRAINERS A USER HAS BOOKED, we use the trainer_id as the foreign key
                * We have a currently logged in user...
                * ... so we join the two tables where the user's ID appears in the bookings table
                * this gives us the trainers who have booked a particular user
            */
            $booked_trainers = DB::table('users')
                ->join('bookings', 'bookings.trainer_id', '=', 'users.id')
                ->select('users.*', 'bookings.day', 'bookings.time', 'bookings.id')
                ->where('bookings.user_id', '=', auth()->user()->id)
                ->get();

                // if(empty($booked_trainers)){
                //     dd($has_bookings);
                //     return view('/dashboard', compact('trainers', 'booked_trainers', 'has_bookings'));
                // }
            
                $has_bookings = true;
            
                // takes us to the dashboard page
                $trainers = User::where('role','like','1') -> get();
                return view('/dashboard', compact('trainers', 'booked_trainers', 'has_bookings'));
        }

        // takes us to the dashboard page
        $trainers = User::where('role','like','1') -> get();
        return view('/dashboard', compact('trainers', 'has_bookings', 'booked_trainer'));
    }

    // allow the user to cancel their booking
    function cancelBooking($booking_id) {
        // get the ID of the booking
        $booking = Booking::find($booking_id);

        // delete it
        $booking->delete();

        // take user back to the dashboard with a success message
        return redirect('dashboard')->with('success', 'Booking Successfully Deleted!');
    }
    
    // takes us to the edit details page
    // we pass th user ID to the view
    function edit($id){
        $user = User::find($id);
        return view('editDetails', compact('user'));
    }

    // to delete the specific user
    function destroy($id){
        // find user via ID
        $user = User::find($id);

        // find bookings of the user
        $user_bookings = Booking::where('user_id','like',$id);

        // delete user account
        $user->delete();

        // delete user's bookings
        $user_bookings->delete();

        // back to home page with success message
        return redirect('home')->with('success', 'Account Successfully Deleted!');
    }

    // book a trainer
    function bookTrainer($user_id, $trainer_id){
        // find user via ID
        $user = User::find($user_id);

        // find trainer via ID
        $trainer = User::find($trainer_id);

        // check of the trainer's daily limit has not been reached
        if ($trainer['trainees_for_today'] > 0) {
            // to the booking page
            return view('book', compact('user', 'trainer'));
        }

        // back to dashboard with warning message
        return redirect('dashboard')->with('danger', 'This Trainer is fully booked. Try Again Tomorrow!');
    }
}
