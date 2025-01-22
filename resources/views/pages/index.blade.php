@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="site-hero overlay" data-stellar-background-ratio="0.5"
        style="background-image: url({{ asset('user/images/bg.png') }});">
        <div class="container">

            <div class="row align-items-center site-hero-inner justify-content-center">
                <x-alerts />
                <div class="col-md-12 text-center">
                    <div class="mb-5 element-animate">
                        <h1>Schedule Pediatric Appointments</h1>
                        <p>Online, Anytime, Anywhere.</p>
                        <p>
                            <a href="{{ route('reservations.book') }}" class="btn btn-primary btn-sm text-black fw-semibold">
                                Book Now
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- END section -->

    <section class="site-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="heading-wrap text-center element-animate">
                        <h2 class="heading text-center">Visit Us</h2>
                        <p class="mb-5 font-italic">"Convenient care at your fingertips! Book your child’s appointment
                            online today and let us take care of their health with compassion and expertise."</p>
                        <p><a href="{{ route('about') }}" class="btn btn-primary btn-sm text-black fw-semibold">More About
                                Us</a></p>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <img src="{{ asset('user/images/about.png') }}" alt="Image placeholder" class="img-md-fluid">
                </div>
            </div>
        </div>
    </section>
    <!-- END section -->


@endsection
