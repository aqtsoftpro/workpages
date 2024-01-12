@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Job Location</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Job Location</li>
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
                  <a href="{{ url('admin/location_states') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/location_states/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('location_states.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="social_media_facebook">
                    </div>
                    <div class="col-md-12">
                      <label for="icon" class="form-label">Location</label>
                      <select class="form-control" name="location_id">
                        <option value="">select Location</option>
                        @foreach($locations as $location)
                          <option value="{{ $location->id }}" {{ ($record->location_id == $location->id)?'selected':'' }}>{{ $location->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label for="social_media_linkedin" class="form-label">Status</label>
                      <select class="form-control" name="status">
                        <option value="enable" {{ ( $record->status == 'enable') ? 'selected' : '' }}>Enable</option>
                        <option value="disable" {{ ( $record->status == 'disable') ? 'selected' : '' }}>Disable</option>
                      </select>
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
