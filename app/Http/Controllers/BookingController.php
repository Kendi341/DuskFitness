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

        $user = User::find($user_id);
        $trainers = User::where('role','like','1') -> get();

        $request ->validate([
            'date' => 'required',
            'time' => 'required'
        ]);

        $data['day'] = $request->input('date');
        $data['time'] = $request->input('time');
        $data['user_id'] = $user_id;
        $data['trainer_id'] = $trainer_id;

        $reservation = Booking::create($data);

        if (!$reservation){
            return view(('book'))->with('error', 'Booking failed, try again!');
        } 

        $booked_trainer = DB::table('users')
        ->distinct()
        ->join('bookings', function($join){
            $join->on('users.id', '=', 'bookings.trainer_id');
            $join->on('users.id' , '=', 'users.id');
        })
        ->select('users.*', 'bookings.day', 'bookings.time')
        ->get();

        
        return view('dashboard', compact('user', 'trainers', 'booked_trainer'))
                ->with('success', 'Successfully Booked Trainer');
        

        // // $booked_trainer = DB::table('users')
        //     ->select('users.firstname, users.lastname')
        //     ->join('bookings', 'bookings.trainer_id', '=', 'users.id')
        //     ->where('users.id', $user)
        //     ->get();

        // $my_bookings = Booking::where('user_id', 'like', $user_id);
        
        // $booked_trainer = User::find($my_bookings, 'like', $trainer_id);

        // dd($booked_trainer);

        
    }
}
