@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Testimonial</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Testimonial</li>
      <li class="breadcrumb-item active">Add Testimonial</li>
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
                Add Testimonial
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/testimonials') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('testimonials.store') }}" class="row g-3" enctype="multipart/form-data">
                  @csrf
                    <input type="hidden" name="slug" value="" id="slug" required>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="" class="form-control" id="name" required>
                    </div>
                    <div class="col-md-12">
                      <label for="designation" class="form-label">Designation</label>
                      <input type="text" name="designation" value="" class="form-control" id="designation" required>
                    </div>
                    <div class="col-md-12">
                      <label for="rating" class="form-label">Rating</label>
                      <select name="rating" class="form-control" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label for="description" class="form-label">Description</label>
                      <textarea  class="form-control" name="description" required></textarea>
                    </div>
                    <div class="col-md-12 mb-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="image" class="form-control" id="image">
                    </div>
                    
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
