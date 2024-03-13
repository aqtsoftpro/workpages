@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Admin User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Admin User</li>
      <li class="breadcrumb-item active">Add Admin User</li>
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
                Add Admin User
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/admin_users') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>
             
            
                <form method="POST"  action="{{ route('users.store') }}" class="row g-3" >
                  @csrf
                 
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Permission</label><br>

                        <div class="row">
                          @foreach ($roles as $role)
                            <div class="form-check col-md-4">
                              <input class="form-check-input" type="radio" id="permission-{{ $role->id }}" name="role[]" value="{{ $role['id'] }}" >
                              <label class="form-check-label" for="permission-{{ $role->id }}">
                                {{ $role['name'] }}
                              </label>
                            </div>
                          @endforeach
                        </div>

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
