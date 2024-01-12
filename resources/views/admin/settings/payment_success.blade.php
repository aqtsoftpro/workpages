@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Payment Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Payment Sucess</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Example Card</h5>


            <div class="alert alert-success">
                The Payment was successfull!
                <a class="btn btn-success" href="{{ url('/admin/settings/payment_settings') }}">Go Back</a>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
