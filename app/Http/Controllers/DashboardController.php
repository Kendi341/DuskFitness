<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

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
                    //$join->on('users.id' , '=', 'users.id');
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
                ->select('users.*', 'bookings.day', 'bookings.time')
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
