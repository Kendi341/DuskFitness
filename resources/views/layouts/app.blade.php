<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <title>@yield('title')</title>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
    body{
        background-color: #F5F5F5;
    }
    #aboutLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #aboutLink:hover{
        color: #BC8F8F;
    }
    #aboutLink:active{
        text-decoration: underline;
    }
    #contactLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #contactLink:hover{
        color: #BC8F8F;
    }
    #contactLink:active{
        text-decoration: underline;
    }
    #loginLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #loginLink:hover{
        color: #BC8F8F
    }
    #loginLink:active{
        text-decoration: underline;
    }
    #registerLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #registerLink:hover{
        color: #BC8F8F;
    }
    #registerLink:active{
        text-decoration: underline;
    }
    #related1{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related1:hover{
        color: #BC8F8F;
    }
    #related1:active{
        text-decoration: underline;
    }
    #related2{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related2:hover{
        color: #BC8F8F;
    }
    #related2:active{
        text-decoration: underline;
    }
    #related3{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related3:hover{
        color: #BC8F8F;
    }
    #related3:active{
        text-decoration: underline;
    }
    .fa {
        padding: 10px;
        font-size: 30px;
        width: 50px;
        text-align: center;
        text-decoration: none;
        border-radius: 10%;
    }
    .fa-facebook {
        background: #3B5998;
        color: white;
    }

    /* Twitter */
    .fa-twitter {
        background: #55ACEE;
        color: white;
    }

    .fa-instagram {
        background: #125688;
        color: white;
    }

    .fa-pinterest {
        background: #cb2027;
        color: white;
    }

</style>
    <header>
        <div class="mb-5">
            <div class="row" style="background-color: black">
                <div class="col-4 mt-5 mb-3 text-center">
                    <a href="{{ route('home')}}"> <img src="{{ asset('Logo/dusk-removebg.png') }}"  class="img-fluid w-75 text-center " alt="Dusk Fitness Center"></a>
                </div>
                <div class="col-8 mt-5">
                    <div class="navbar justify-content-end">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a id="aboutLink" class="nav-link fs-5" href="/home">About</a>
                            </li>
                            <li class="nav-item">
                                <a id="contactLink" class="nav-link fs-5" href="/home">Contact</a>
                            </li>
                            @if(auth()->user())
                                @if (auth()->user()->role == 0 || auth()->user()->role == -1)
                                    <li class="nav-item">
                                        <a id="contactLink" class="nav-link fs-5" href="{{ route('admindash', ['adminID'=>auth()->user()->id]) }}">Hello {{auth()->user()->firstname}}</a>
                                    </li>

                                @else
                                    <li class="nav-item">
                                        <a id="contactLink" class="nav-link fs-5" href="{{ route('dashboard') }}">Hello {{auth()->user()->firstname}}</a>
                                    </li>
                                    
                                @endif

                                <li class="nav-item">
                                    <a id="contactLink" class="nav-link fs-5" href="{{ route('logout') }}">Logout</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a id="loginLink" class="nav-link fs-5" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a id="registerLink" class="nav-link fs-5" href=" {{ route('register')}} ">Member Register</a>
                                </li>
                                <li class="nav-item">
                                    <a id="registerLink" class="nav-link fs-5" href=" {{ route('trainer.register') }} ">Become a Trainer</a>
                                </li>
                            @endif
                            
                        </ul>
                    </div>
                </div>
                
            </div>
            
        </div>  
        
        <main>
            @yield('content')
        </main>
    </header>

    <footer class="mt-4 p-3" style="background-color: #1B1B1B">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-4">
                    <a href="{{ '/home' }}"><img class="w-100" src="{{ asset('/Logo/dusk-removebg.png') }}"/></a>

                    <hr style="color: white">
                    <h5 style="color: #FFE4E1"> Our Social Media </h5>
                    <hr style="color: white">
                    <div class="social" style="margin-top: 20px">
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-instagram"></a>
                        <a href="#" class="fa fa-pinterest"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <hr style="color: white">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Contact Us </h5>
                    <hr style="color: white">
                    
                    <p style="color: #FFE4E1"> Tel:
                    (+254) (0)703-034000/200/300</p>
                    <p style="color: #FFE4E1"> (+254) (0) 730-734000/200/300 </p>
                    <p style="color: #FFE4E1"> Email: 
                    <a href="mailto:info@nataliekendi.co.ke" id="link_email">info@duskfitness.com</a></p>

                    <hr style="color: white">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Address </h5>
                    <hr style="color: white">

                    <p style="color: #FFE4E1"> Langata Road, off Langata Road, in Langata Estate, Nairobi, Kenya. </p>
                </div>
                <div class="col-md-4">
                    <hr style="color: white">
                    <h5 style="color: #FFE4E1"> Related Links </h5>
                    <hr style="color: white">

                    <a id="related1" class="text-decoration-none" href="https://thenx.com/" id="link" target="_blank"> <p> Thenx Athlete </p> </a>
                    <a id="related2" class="text-decoration-none" href="https://www.hybridcalisthenics.com/" id="link" target="_blank"> <p> Hybrid Calisthenics </p> </a>
                    <a id="related3" class="text-decoration-none" href="https://row.gymshark.com/" id="link" target="_blank"> <p> Gym Shark </p> </a>
                </div>
            </div>
        </div>
    </footer>
</html>
