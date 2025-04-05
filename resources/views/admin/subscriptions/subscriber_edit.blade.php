@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Subscribers</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Edit Subscriber</li>
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
                  <a href="{{ url('admin/subscribers') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>

                <form method="POST" action="{{ route($record->status == 'pending' ? 'subscriber.update' : 'subscriptions.update', $record->id) }}" class="row g-3">

                  @csrf
                  @method('PUT')
                    <input type="hidden" name="subscription_id" value="{{ $record->id }}">
                    <div class="col-md-6">
                      <label for="name" class="form-label">Name</label>
                      {{-- <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="social_media_facebook"> --}}
                      <select name="package_id" id="" class="form-select">
                        @foreach ($packages as $package)
                          <option value="{{ $package->id }}" @selected($record->name == $package->name )>{{ $package->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            {{ $record->status == 'pending' ? 'Activate' : 'Update' }}
                        </button>
                    </div>

                </form>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
