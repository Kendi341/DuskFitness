<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    // to login page
    function login(){
        return view('/auth/login');
    }

    // to register page
    function register(){
        return view('/auth/register');
    }

    // to trainer register page
    function trainerregister(){
        return view('/auth/trainerregister');
    }

    // receives a request that contains all the data from the login form
    // all data from the login form can be accessed through the request variable created below
    function loginPost(Request $request){
        // we validate the form, checking for availability of the variables (email and password) as per the form
        // if the items are not present, it displays an error automatically
        // has key => value pairs syntax
        // the key is obtained from the form (the NAME of the input)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // first, we check if the the trainer trying to log in has been approved by the admin(s)
        // then, we check if the account is active, inactive or suspended
        $trainer_approval = User::where('email',$request->email)->first();

        if ($trainer_approval->approval == 'no') {
            return redirect(route('login'))->with('warning', 'Your Trainer Account is Pending Approval!');
        } else if ($trainer_approval->status == 'inactive') {
            return redirect(route('login'))->with('warning', 'Your approval request has been rejected, kindly contact customer support via inquire@duskfitness.com');
        } else if ($trainer_approval->status == 'suspended'){
            return redirect(route('login'))->with('warning', 'Your account has been suspended, kindly contact customer support via inquire@duskfitness.com');
        }
        
        // gets and stores the form input in the credentials variable
        $credentials = $request->only('email', 'password');

        // here, we do the actual login
        // if the user attempts to login
        if(Auth::attempt($credentials)){
            // here, we check who is trying to log in. 
            // It could be a trainer (role=1), a member (role=2), a normal admin (role=0) or a superadmin (role=-1)
            // if successful, redirect to the respective page (given the route a name)
            // this redirect goes with a success message which will be printed at the home page
            if (auth()->user()->role == 0 || auth()->user()->role == -1){
                return redirect()->intended('admin/'.auth()->user()->id)->with('success', 'Login Successful!');
            }

            // to dashboard with success message
            return redirect()->intended(route('dashboard'))->with('success', 'Login Successful!');
        }
        // if not successful, redirect to the login page with an error message
        return redirect(route('login'))->with('error', 'Login Details Incorrect!');
    }

    // receives a request containing the data from the register form
    function registerPost(Request $request){
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
        $data['role'] = 2;
        $data['status'] = 'active';
        $data2['confirm_password'] = $request->confirm_password;

        // check if passwords match
        if ($data['password'] != $data2['confirm_password']){
            return redirect(route('register'))->with('error', 'Passwords do not match!');
        }

        // encrypt the password
        $data['password'] = Hash::make($request->password);

        // insert the user in the database
        // we use a model
        // a model does all the queries to the database
        // the below creates a user by passing in to the model all the items which the user has inputted
        $user = User::create($data);

        // check if user creation is successful
        // if there is no user
        if (!$user){
            return redirect(route('register'))->with('error', 'Registration failed, try again!');
        } 

        // back to home page with success message
        return redirect(route('home'))->with('success', 'Registration Successful!');
    }

    // receives a request containing the data from the register form
    function trainerregisterPost(Request $request){
        // validating the request as we did in login
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'no_of_trainees' => 'required',
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
        $data['approval'] = 'no';
        $data['no_of_trainees'] = $request->no_of_trainees;
        $data['password'] = $request->password;
        $data2['confirm_password'] = $request->confirm_password;
        $data['role'] = 1;
        $data['status'] = 'pending approval';

        // check if passwords match
        if ($data['password'] != $data2['confirm_password']){
            return redirect(route('register'))->with('error', 'Passwords do not match!');
        }

        // encrypt the password
        $data['password'] = Hash::make($request->password);

        // number of trainees = trainees for the day
        $data['trainees_for_today'] = $data['no_of_trainees'];

        // insert the user in the database
        // we use a model
        // a model does all the queries to the database
        // the below creates a user by passing in to the model all the items which the user has inputted
        $user = User::create($data);

        // check if user creation is successful
        // if there is no user
        if (!$user){
            return redirect(route('register'))->with('error', 'Registration failed, try again!');
        }
        
        // back to home page with success message
        return redirect(route('home'))->with('success', 'Registration Successful!');
    }

    // logout function
    // clean the session
    // logout the user and redirect them
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('home'))->with('success', 'Logout Successful!');
    }
}
