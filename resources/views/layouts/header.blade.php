<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="border border-dark">
    <div class="header">
        <div class="navbar justify-content-center mt-5 border border-primary">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                <a class="nav-link" href="/home">About</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/home">Contact</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{ url('login') }}">Login</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href=" {{ url('register')}} ">Register</a>
                </li>
            </ul>
        </div>
        <div class="row justify-content-center border border-success">
            <img src="{{ asset('Logo/logo.png') }}" href="{{ url('../index')}}" class="img-fluid w-25 text-center " alt="Maestro Gym">
        </div>
    </div>

@yield('content')
