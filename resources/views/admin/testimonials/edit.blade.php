@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Edit Testimonial</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Edit Testimonial</li>
      <li class="breadcrumb-item active">{{ $record->name }}</li>
    </ol>
  </nav>
</div>

@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif(Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
  @php
    // echo "<pre>";
    //   // print_r($record);
    //   echo $record->designation;
    // echo "</pre>";
  @endphp
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
                  <a href="{{ url('admin/testimonials') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/testimonials/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('testimonials.update',$record->id) }}" class="row g-3" enctype="multipart/form-data">
                  
                  @csrf
                  @method('PUT')
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="social_media_facebook">
                    </div>
                    <div class="col-md-12">
                      <label for="designation" class="form-label">Designation</label>
                      <input type="text" name="designation" class="form-control" id="designation" value="{{ $record->designation }}" required>
                    </div>
                    <div class="col-md-12">
                      <label for="rating" class="form-label">Rating</label>
                      <select name="rating" class="form-control" required>
                        <option value="1" {{ ( $record->rating == '1') ? 'selected' : '' }}>1</option>
                        <option value="2" {{ ( $record->rating == '2') ? 'selected' : '' }}>2</option>
                        <option value="3" {{ ( $record->rating == '3') ? 'selected' : '' }}>3</option>
                        <option value="4" {{ ( $record->rating == '4') ? 'selected' : '' }}>4</option>
                        <option value="5" {{ ( $record->rating == '5') ? 'selected' : '' }}>5</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label for="designation" class="form-label">Description</label>
                      <textarea  class="form-control" name="description" required>{{ $record->description }}</textarea>
                    </div>
  
                    <div class="col-md-6 mb-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="image" value="" class="form-control" id="image" >
                    </div>
                    <div class="col-md-6 mb-2">
                      @if (isset($record->image))
                        @php
                          $image  = $record->image;
                        @endphp
                        <div class="admin-manage-img-container">
                        <i class="bi bi-x-octagon-fill delete-img-btn delete-site-logo-btn"></i>
                        <img src="{{ $image }}" width="150" height="150" />
                        <input type="hidden" name="image" value="{{ ($image)? $image:'' }}" class="form-control" id="exist_site_logo">
                        </div>
                        
                      @else
                          @php $image  = URL::to('/uploads/no-img.jpg') @endphp
                          <img src="{{ $image }}" width="150" height="150" />
                      @endif
                    </div>
                    <hr>
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

  <script type="">
    $(document).ready(function() 
    {

      $(".delete-img-btn").click(function(){
        $(this).parent().hide();
        $(this).parent().find("input").val('')
      });

    });
  </script>

@endsection
