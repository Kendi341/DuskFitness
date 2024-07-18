@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
              @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
              @endif
              @if(session()->has('danger'))
                  <div class="alert alert-danger">
                      {{ session('danger') }}
                  </div>
              @endif
                <div class="col-9 text-center">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item active" data-bs-interval="10000">
                            <img src="{{ asset('Carousel_Images/back.jpg') }}" class="d-block w-100" alt="Workout">
                          </div>
                          <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('Carousel_Images/lady.jpg') }}" class="d-block w-100" alt="Workout">
                          </div>
                          <div class="carousel-item">
                            <img src="{{ asset('Carousel_Images/stretch2.jpg') }}" class="d-block w-100" alt="Workout">
                          </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>
                </div>
                <div class="col-3 text-center align-content-center">
                    <h5>With the latest equipment, we assure you gains upon gains. <br><br> Come on down, one and all, young and old. We will help you train. <br><br> Are you ready to achieve that dream? Become a member or register to become a trainer below 👇</h5>
                    <br><br>
                    <div class="d-flex">
                      <a class="me-3" href="{{ route('trainer.register') }}">
                        <button class="btn btn-outline-primary">Become a Trainer</button>
                      </a>
                      <a class="ms-3" href="{{ route('register') }}">
                        <button class="btn btn-outline-primary">Register as a Trainer</button>
                      </a>
                    </div>
                    
                </div>
            </div>
            <div class="row mt-5 p-4">
                <div class="col">
                    <h3 class=text-center>ABOUT US</h3>
                    <p>We are a community of fitness specialists and enthusiast, started in 2022 with the aim of growing the biggest community of trainers and members. We believe in the essenciality of pushing our bodies to the limit and unveiling our true potential. Our state of the art equipment and approved trainers aim to assist members in not just looking string, but actually being stong</p>
                </div>
            </div>

            <div class="row mt-5 p-4 ">
                <div class="col">
                    <h3 class=text-center>CONTACT US</h3>
                    <p>For member and trainer registration enquiries please email: <a href="mailto:inquire@duskfitness.com">inquire@duskfitness.com</a>
                      <br>
                      
                      For general business enquiries please email: <a href="mailto:corporate@duskfitness.com">corporate@duskfitness.com</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
@endsection

