@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Package</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Edit Package</li>
      <li class="breadcrumb-item active">{{ $record->name }}</li>
    </ol>
  </nav>
</div>

@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif(Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title row">
              <div class="col-lg-6">
                Edit {{ $record->name }}
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/subscriptions') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/subscriptions/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('subscriptions.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                    <div class="col-md-6">
                      <label for="name" class="form-label">Name</label>
                      {{-- <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="social_media_facebook"> --}}
                      <select name="package_id" id="" class="form-select">
                        @foreach ($packages as $package)
                          <option value="{{ $package->id }}" @selected($record->name == $package->name )>{{ $package->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="price" class="form-label">Stripe ID</label>
                      <input type="text" name="stripe_id" value="{{ $record->stripe_id }}" class="form-control" id="price" required>
                    </div>

                    <div class="col-md-6">
                      <label for="price" class="form-label">Stripe Price ID</label>
                      <input type="text" name="stripe_price" value="{{ $record->stripe_price }}" class="form-control" id="price" required>
                    </div>

                    <div class="col-md-6">
                      <label for="price" class="form-label">Quantity</label>
                      <input type="text" name="quantity" value="{{ $record->quantity }}" class="form-control" id="price" required>
                    </div>  
                    <div>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    
                </form>
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
