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
                  <a href="{{ url('admin/permissions') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/permissions/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
              @php
                $roles = $record->roles;  
                $roleIds = $roles->pluck('id')->toArray(); 
              @endphp 
            
                <form method="POST"  action="{{ route('users.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                  <div class="col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $record->name }}" required>
                  </div>
                  <div class="col-md-12">
                    <label for="name" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $record->email }}" readonly required>
                  </div>

                  <div class="col-md-12">
                    <label for="name" class="form-label">Email Verified At</label>
                    <input type="datetime-local" name="email_verified_at" value="{{ $record->email_verified_at ?? old('email_verified_a', now()->toDateString() ) }}" class="form-control" id="email_verified_at">
                  </div>

                  <div class="col-md-12">
                    <label for="name" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                  </div>
                  <div class="col-md-12">
                    <label for="name" class="form-label">Permission</label><br>
                      <div class="row">
                        @foreach ($user_roles as $role)
                          <div class="form-check col-md-4">
                            <input class="form-check-input" type="radio" id="permission" name="role[]" value="{{ $role['id'] }}" 
                            {{ $roleIds[0] == $role['id']?'checked':''; }} >
                            <label class="form-check-label" for="permission">
                              {{ $role['name'] }}
                            </label>
                          </div>
                        @endforeach
                      </div>

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
