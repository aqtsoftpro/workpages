@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Job Category</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Job Category</li>
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
                  <a href="{{ url('admin/job_categories') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/job_categories/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('job_categories.update',$record->id) }}" class="row g-3" enctype="multipart/form-data">
                  
                  @csrf
                  @method('PUT')
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="name">
                    </div>
                    <div class="col-md-12">
                      <label for="slug" class="form-label">Slug</label>
                      <input type="text" name="slug" value="{{ $record->slug }}" class="form-control disabled" id="slug" disabled readonly>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="image" value="" class="form-control" id="image" accept=".png,.svg">
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
                      @endif
           
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
