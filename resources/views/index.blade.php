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
                    <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores pariatur, ut, quas corrupti voluptas harum exercitationem nulla animi nisi, impedit dolore veniam consequatur officiis deleniti saepe. Optio dolore perspiciatis consequatur!</h5>
                </div>
            </div>
            <div class="row mt-5 p-4">
                <div class="col">
                    <h3 class=text-center>ABOUT US</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore quidem quia laboriosam unde voluptatum placeat quaerat, repudiandae suscipit exercitationem iusto ipsam nostrum, autem quasi perferendis commodi nisi maxime repellendus vero.</p>
                </div>
            </div>

            <div class="row mt-5 p-4 ">
                <div class="col">
                    <h3 class=text-center>CONTACT US</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore quidem quia laboriosam unde voluptatum placeat quaerat, repudiandae suscipit exercitationem iusto ipsam nostrum, autem quasi perferendis commodi nisi maxime repellendus vero.</p>
                </div>
            </div>
        </div>
    </div>
    
@endsection

