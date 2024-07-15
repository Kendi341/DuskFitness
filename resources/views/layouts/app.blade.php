<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


</head>
<style>
    #aboutLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #aboutLink:hover{
        color: #D8BFD8;
    }
    #aboutLink:active{
        text-decoration: underline;
    }
    #contactLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #contactLink:hover{
        color: #D8BFD8;
    }
    #contactLink:active{
        text-decoration: underline;
    }
    #loginLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #loginLink:hover{
        color: #D8BFD8
    }
    #loginLink:active{
        text-decoration: underline;
    }
    #registerLink{
        color: #FFE4E1;
        cursor: pointer;
    }
    #registerLink:hover{
        color: #D8BFD8;
    }
    #registerLink:active{
        text-decoration: underline;
    }
    #related1{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related1:hover{
        color: #D8BFD8;
    }
    #related1:active{
        text-decoration: underline;
    }
    #related2{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related2:hover{
        color: #D8BFD8;
    }
    #related2:active{
        text-decoration: underline;
    }
    #related3{
        color: #FFE4E1;
        cursor: pointer;
    }
    #related3:hover{
        color: #D8BFD8;
    }
    #related3:active{
        text-decoration: underline;
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
                                <li class="nav-item">
                                    <a id="contactLink" class="nav-link fs-5" href="{{ route('dashboard') }}">Hello {{auth()->user()->firstname}}</a>
                                </li>

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

                    <h5 style="color: #FFE4E1"> Our Social Media </h5>
                    <div class="social" style="margin-top: 20px">
                        <a href="https://web.facebook.com/StrathmoreUniversity?_rdc=1&_rdr" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/strathmore.university" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/StrathU" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.youtube.com/user/StrathmoreUniversity" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.linkedin.com/school/strathmore-university/" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <hr class="light">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Contact Us </h5>
                    <hr class="light">
                    
                    <p style="color: #FFE4E1"> Tel:
                    (+254) (0)703-034000/200/300</p>
                    <p style="color: #FFE4E1"> (+254) (0) 730-734000/200/300 </p>
                    <p style="color: #FFE4E1"> Email: 
                    <a href="mailto:info@nataliekendi.co.ke" id="link_email">info@duskfitness.com</a></p>

                    <hr class="light" style="margin-top: 20px">
                    <h5 id="footer_sub" style="color: #FFE4E1"> Address </h5>
                    <hr class="light">

                    <p style="color: #FFE4E1"> Ole Sangale Road, off Langata Road, in Madaraka Estate, Nairobi, Kenya. </p>
                </div>
                <div class="col-md-4">
                    <hr class="light">
                    <h5 style="color: #FFE4E1"> Related Links </h5>
                    <hr class="light">

                    <a id="related1" class="text-decoration-none" href="https://thenx.com/" id="link" target="_blank"> <p> Thenx Athlete </p> </a>
                    <a id="related2" class="text-decoration-none" href="https://www.hybridcalisthenics.com/" id="link" target="_blank"> <p> Hybrid Calisthenics </p> </a>
                    <a id="related3" class="text-decoration-none" href="https://row.gymshark.com/" id="link" target="_blank"> <p> Gym Shark </p> </a>
                </div>
            </div>
        </div>
    </footer>
</html>
