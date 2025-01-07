@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section class="site-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url({{ asset('user/images/bg.png') }});">
    <div class="container">
      <div class="row align-items-center site-hero-inner justify-content-center">
        <div class="col-md-12 text-center">
          <div class="mb-5 element-animate">
            <h1>Contact Us</h1>
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
          <h2 class="mb-5">Contact Form</h2>
        <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="name" style="font-weight: bold">Name</label>
                    <input type="text" id="name" class="form-control border border-dark">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="phone" style="font-weight: bold">Phone</label>
                    <input type="text" id="phone" class="form-control border border-dark">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="message" style="font-weight: bold">Write your concern</label>
                    <textarea name="message" id="message" class="form-control border border-dark" cols="30" rows="8"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="submit" value="Send Message" class="btn btn-primary">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-1 mt-2"></div>
            <div class="col-md-5">
              <h3 class="mt-3 mb-2 fw-bolder text-muted">Tell us your concern</h3>
              <p class="mb-3 text-center"><img src="{{ asset('user/images/contact.png') }}" alt="Contact Image" class="img-fluid img-fluid d-inline-block" style="max-width: 300px; height: auto;"></p>
              <p class="lead font-italic text-justify">"Get in touch with us today! Whether you have questions or need to schedule an appointment, we’re here to provide the care and support your child deserves."</p>
            </div>
      </div>
    </div>
  </section>
  <!-- END section -->

{{-- <section class="site-section">
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-6">
          <h2 class="mb-5">Contact Form</h2>
        <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="name" class="fw-bolder">Name</label>
                    <input type="text" id="name" class="form-control ">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="phone" class="fw-bolder">Phone Number</label>
                    <input type="text" id="phone" class="form-control ">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="message" class="fw-bolder">Write your concern</label>
                    <textarea name="message" id="message" class="form-control " cols="10" rows="5"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="submit" value="Send Message" class="btn btn-primary">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <h3 class="mb-5">Contact Us</h3>
              <p class="mb-5 d-flex align-items-center justify-center"><img src="{{ asset('user/images/about.png') }}" alt="Image placeholder" class="img-md-fluid" style="width: 90px; height: 50px"></p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae labore aspernatur cumque inventore voluptatibus odit doloribus! Ducimus, animi perferendis repellat. Ducimus harum alias quas, quibusdam provident ea sed, sapiente quo.</p>
              <p>Ullam cumque eveniet, fugiat quas maiores, non modi eos deleniti minima, nesciunt assumenda sequi vitae culpa labore nulla! Cumque vero, magnam ab optio quidem debitis dignissimos nihil nesciunt vitae impedit!</p>
            </div>
      </div>
    </div>
</section>
  <!-- END section --> --}}

@endsection
