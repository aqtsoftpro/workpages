@extends('layouts.guest')

@section('content')

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        @if(Session::get('status') == 'verification-link-sent')
        <div class="alert alert-success">
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
            @php
                Session::forget('success');
            @endphp
        </div>
        @endif

      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="d-flex justify-content-center py-4">
            <a href="index.html" class="logo d-flex align-items-center w-auto">
              {{-- <img src="{{ get_site_logo('_site_logo') }}" alt=""> --}}
              <span class="d-none d-lg-block">

                </span>
            </a>
          </div><!-- End Logo -->

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                 <h5 class="card-title text-center pb-0 fs-4">Please Verify Your Email</h5>
                <p class="text-center small">Check you email inbox or click here to send link again</p>
              </div>

              <form method="POST" action="{{ route('verification.send') }}" class="row mb-3 g-3 needs-validation" novalidate>
                @csrf

                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit" >Resend Email Link</button>
                </div>
              </form>

              <form method="POST" action="{{ route('logout') }}" class="float-end">
                @csrf
    
                <button type="submit" class="btn btn-primary float-end">
                    {{ __('Log Out') }}
                </button>
            </form>

            </div>
          </div>

          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
          </div>

        </div>
      </div>
    </div>

  </section>
@endsection
