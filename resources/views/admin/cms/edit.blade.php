@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>CMS</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">CMS</li>
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
                  <a href="{{ url('admin/manage_pages') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/manage_pages/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('manage_pages.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="name">
                    </div>
                    <div class="col-md-12">
                      <label for="slug" class="form-label">Slug</label>
                      <input type="text" name="slug" value="{{ $record->slug }}" class="form-control" id="slug" disabled readonly>
                    </div>
                    <div class="col-md-12">
                      <!-- TinyMCE Editor -->
                      <textarea name="desc" class="tinymce-editor">{{ stripslashes($record->desc) }}</textarea>
                      <!-- End TinyMCE Editor -->
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
