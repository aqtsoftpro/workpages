@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Job Technology</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Job Technology</li>
      <li class="breadcrumb-item active">Add Technology</li>
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
                Add Job Technology
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/technologies') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('technologies.store') }}" class="row g-3" >
                  @csrf
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="" class="form-control" id="name" required>
                    </div>
                    {{-- <div class="col-md-12">
                      <label for="icon" class="form-label">Icon</label>
                      <input type="text" name="icon" value="" class="form-control" id="icon" required>
                    </div> --}}
                    <div class="col-md-12">
                      <label for="social_media_linkedin" class="form-label">Status</label>
                      <select class="form-control" name="status" required>
                        <option value="enable">Enable</option>
                        <option value="disable">Disable</option>
                      </select>
                    </div>
  
                    <div>
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                    
                </form>
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
