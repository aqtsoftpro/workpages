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
                  <a href="{{ url('admin/roles') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/roles/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
                <form method="POST"  action="{{ route('roles.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                    
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="social_media_facebook">
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Permission</label><br>
               
                      @foreach ($perm_cat['per_cat'] as $key => $record)
                        <b>{{ $record }}</b><br><br>

                        <div class="row">
                          @foreach ($perm_cat['permission'][$key] as $permission)
                            <div class="form-check col-md-4">
                              <input class="form-check-input" type="checkbox" id="permission" name="role[{{ $permission['id'] }}]" 
                              {{ isset($permissions[$permission['id']])?'checked':'' }}
                              >
                              <label class="form-check-label" for="permission">
                                {{ $permission['name'] }}
                              </label>
                            </div>
                          @endforeach
                        </div>

                        <hr>
                      @endforeach
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
