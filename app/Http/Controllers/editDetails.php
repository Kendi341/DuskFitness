<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class editDetails extends Controller
{
    // this actually edits the user's details
    function editStuff($id, Request $request){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }
        
        // find that specific user in the DB
        $users = User::find($id);

        // set the new credentials that the user has entered
        $users->firstname = $request->input('fname');
        $users->lastname = $request->input('lname');
        $users->address = $request->input('address');
        $users->email = $request->input('email');

        // check if the password fields are empty
        if ($request ->input('new_password') == null && $request ->input('conf_new_password') == null) {
            // update new user credentials on the DB
            $users->update();

            // redirect to dashboard with success message
            return redirect('dashboard')->with('success', 'Your details have been updated!');

        // input validation for the password fields
        } else if ($request ->input('new_password') != null && $request ->input('conf_new_password') == null) {
            return redirect('dashboard')->with('warning', 'Confirm Password Field is empty!');
        } else if ($request ->input('new_password') == null && $request ->input('conf_new_password') != null) {
            return redirect('dashboard')->with('warning', 'Password Field is empty!');
        } else if ($request ->input('new_password') != null && $request ->input('conf_new_password') != null) {
            // hash and update password in the db
            $users->password = Hash::make($request ->input('new_password'));
            $users->update();

            // redirect to dashboard with a success message
            return redirect('dashboard')->with('success', 'Your details have been updated!');
        }
    }
}
