<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


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
            return redirect('dashboard')->with('success', 'Your details have been updated!');
        } else if ($request ->input('new_password') != null && $request ->input('conf_new_password') == null) {
            return redirect('dashboard')->with('warning', 'Confirm Password Field is empty!');
        } else if ($request ->input('new_password') == null && $request ->input('conf_new_password') != null) {
            return redirect('dashboard')->with('warning', 'Password Field is empty!');
        } else if ($request ->input('new_password') != null && $request ->input('conf_new_password') != null) {
            $users->update();
            return redirect('dashboard')->with('success', 'Your details have been updated!');
        }
    }
}
