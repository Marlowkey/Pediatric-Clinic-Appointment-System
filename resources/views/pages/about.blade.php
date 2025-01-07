@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<section class="site-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url({{ asset('user/images/bg.png') }});">
  <div class="container">
    <div class="row align-items-center site-hero-inner justify-content-center">
      <div class="col-md-12 text-center">
        <div class="mb-5 element-animate">
          <h1>About Us</h1>
          <p>Online, Anytime, Anywhere.</p>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- END section -->


<section class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-wrap element-animate">
                    <h3 class="heading fw-bolder" style="color: #0ABE73">Welcome to Clarianes Pediatric Clinic!</h3>
                    <p style="text-align: justify;">At Clarianess Pediatric Clinic, we are dedicated to providing compassionate, high-quality healthcare for children of all ages. Our experienced team of pediatric specialists prioritizes your child's health and well-being, offering personalized care in a warm, family-friendly environment.  </p>
                    <p style="text-align: justify;">Whether it's routine check-ups, immunizations, or addressing specific health concerns, our clinic is here to support your child's growth and development every step of the way. At Clarianess, we believe in building strong partnerships with parents to ensure every child thrives. </p>
                    <p style="text-align: justify;">Your child's health is our priority! </p>
                </div>
            </div>
            <div class="col-md-6 align-items-center justify-center">
              <img src="{{ asset('user/images/4.png') }}" alt="Image placeholder" class="img-md-fluid">
            </div>
        </div>
    </div>
</section>
<!-- END section -->




@endsection

