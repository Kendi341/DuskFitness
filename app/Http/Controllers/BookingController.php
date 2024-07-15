<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;


class BookingController extends Controller
{
    function book($user_id, $trainer_id, Request $request){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get details of the currently logged in user
        $user = User::find($user_id);

        // get all trainers
        $trainers = User::where('role','like','1') -> get();

        // get that specific trainer
        $trainer = User::find($trainer_id);

        // validate that the incoming fields have been field
        $request ->validate([
            'date' => 'required',
            'time' => 'required'
        ]);

        // extract value input by user
        $data['day'] = $request->input('date');
        $data['time'] = $request->input('time');
        $data['user_id'] = $user_id;
        $data['trainer_id'] = $trainer_id;

        // check if the date and the time that the user has entered already exists in the DB
        $time_checker = Booking::select('time')->where('time', $data['time'])->exists();
        $day_checker = Booking::select('day')->where('day', $data['day'])->exists();

        // if the date and the time already exist, display the error message
        if($time_checker && $day_checker){
            return redirect('book-trainer/'.$user_id.'/'.$trainer_id)->with('danger', 'You have already made a booking at this time! Kindly pick another time');
        }

        $daily_trainees = $trainer['trainees_for_today'];

        // reduce the reservation positions by 1
        $trainer->trainees_for_today = $daily_trainees - 1;
        $trainer->save();

        // create a booking entry on the bookings table
        $reservation = Booking::create($data);
        
        // if the booking did not work
        if (!$reservation){
            return view('book', compact('user', 'trainer'))->with('error', 'Booking failed, try again!');
        } 

        // this shows that the user indeed has booked a trainer
        $has_bookings = true;

        // select the trainer's name, time and day at which the user has booked them
        $booked_trainer = DB::table('users')
        ->distinct()
        ->join('bookings', function($join){
            $join->on('users.id', '=', 'bookings.trainer_id');
            // $join->on('users.id' , '=', 'users.id');
        })
        ->select('users.*', 'bookings.day', 'bookings.time')
        ->get();

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

        
        // redirect to the dashboard page            
        return view('dashboard', compact('user', 'trainers', 'booked_trainer', 'booked_trainers', 'has_bookings'))
                ->with('success', 'Successfully Booked Trainer');
    }
}
