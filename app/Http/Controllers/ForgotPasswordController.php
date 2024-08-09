<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class ForgotPasswordController extends Controller
{
    // to Forgot Password Page
    function forgotPasswordPage(){
        return view('auth.forgotpassword');
    }

    function forgotPasswordCheck(Request $request){
        // we validate the form, checking for availability of the variables (email) as per the form
        // if the items are not present, it displays an error automatically
        // has key => value pairs syntax
        // the key is obtained from the form (the NAME of the input)
        $request->validate([
            'email' => 'required|email',
        ]);

        // check if the email input exists in the db
        $userEmailCheck = User::select('email')->where('email', $request->email)->exists();

        // if not, redirect to the forgot password page with an error
        if (!$userEmailCheck){
            return Redirect::back()->withErrors(
                [
                    'email' => 'User Not Found! Kindly Check the Email Entered and Try Again!'
                ]
            );
            //return view('auth.forgotpassword')->with('danger', 'User does not exist! Kindly confirm your email address is correct!');
        }

        // get ID of the user
        $user = User::where('email','like',$request->email)->first();
        $userID = $user->id;

        // if so, redirect to the reset password page with a success message
        return view('auth.resetpassword', compact('userID'))->with('success', 'User Found! Input New Password');
    }

    //to reset password page
    function resetPassword($user_ID) {
        return view('auth.resetpassword');
    }

    function changePassword(Request $request, $user_ID) {
        // we validate the form, checking for availability of the variables (new and confirm passwords) as per the form
        // if the items are not present, it displays an error automatically
        // has key => value pairs syntax
        // the key is obtained from the form (the NAME of the input)
        $request->validate([
            'new_password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*#?&]/'],
            'confirm_password' => 'required',
        ]);

        // store the data in an array
        $data['new_password'] = $request->new_password;
        $data['confirm_password'] = $request->confirm_password;

        // check if new password matches the confirm password
        if ($data['new_password'] != $data['confirm_password']){
            return redirect(route('resetPassword'))->with('error', 'Passwords do not match!');
        }

        // hash the new password
        $data['new_password'] = Hash::make($request->new_password);

        // find the user by ID
        $user = User::find($user_ID);

        // set the new password
        $user->password = $data['new_password'];

        // update the new password in the db
        $user->update();

        // back to login with success message
        return redirect('/login')->with('success', 'Password Successfully Reset!');
    }
}
