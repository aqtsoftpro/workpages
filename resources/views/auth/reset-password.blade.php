@extends('layouts.guest')

@section('content')
@php
  // echo $password = Hash::make('admin');
@endphp
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
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
                 <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                <p class="text-center small">Enter your email & password to login</p>
              </div>

              <form action="{{ route('password.store') }}" method="post" class="row g-3 needs-validation" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Email</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" name="email" value="{{ old('name', $request->email) }}" class="form-control" id="yourUsername" required>
                    @if ($errors->has('email'))
                        <div class="invalide-feedback">{{ $errors->first('name') }}</div>
                    @endif
                  </div>
                </div>

                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword" required>
                  @if ($errors->has('password'))
                    <div class="invalide-feedback">{{ $errors->first('password') }}</div>
                  @endif
                </div>

                <div class="col-12">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                      <div class="invalide-feedback">{{ $errors->first('password') }}</div>
                    @endif
                  </div>

                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                </div>
                {{--  <div class="col-12">
                  <p class="small mb-0">Dont have account? <a href="pages-register.html">Create an account</a></p>
                </div>  --}}
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


{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
