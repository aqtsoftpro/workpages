@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Profile Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Profile</li>
        <li class="breadcrumb-item active">Profile Settings</li>
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
            <h5 class="card-title"></h5>
           
                <form method="POST" id="profile-form"  action="{{ url('admin/profile') . '/' . $user->id }}" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                    @method('PUT')
                    @csrf

                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="admin_name" value="{{ $user->name }}" class="form-control" id="name" required>
                      <div class="invalid-feedback">
                        Please enter the name.
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="admin_email" value="{{ $user->email }}" class="form-control" id="email"  readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Profile Image</label>

                        <input type="file" name="admin_img" value="" class="form-control" id="admin_img">
                        
                    </div>
    
                    <div class="col-md-6">
                      @if ($user->photo)
                        @php
                          $profile_img  = $user->photo;
                        @endphp
                        <div class="admin-manage-img-container">
                        <i class="bi bi-x-octagon-fill delete-img-btn delete-admin-img-btn"></i>
                        <img src="{{ $profile_img }}" width="150" height="150" />
                        <input type="hidden" name="exist_admin_img" value="{{ $user->photo }}" id="exist_site_logo">
                        </div>
                      @endif
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-12">
                      <label for="password" class="form-label">Current Password</label>
                      <input type="password" name="password" class="form-control" id="password">
                    
                    </div>
                    <div class="col-md-12">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" id="new_password">
                        
                    </div>
                    <div class="col-md-12">
                        <label for="confirmed_password" class="form-label">Confirm New Password</label>
                        <input type="password" name="confirmed_password" class="form-control" id="confirmed_password">
                   
                    </div>
                    <div class="col-md-12" id="passwordError">
                      
                    </div>
               
                    <div class="col-md-12 mt-4">
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

      $(".delete-admin-img-btn").click(function(){
        $(this).parent().hide();
        $(this).parent().find("input").val('')
      });

    });
  </script>

  <script type="">
    $(document).ready(function() {
    
      $(".admin-edit-img-container").click(function(){
        $('.admin-edit-img-container').hide();
        $('#exist_admin_img').val('');
      });

      $('#profile-form').submit(function (e) 
      {
                // Prevent the form from submitting
                var password  = $('#password').val();
                var new_password  = $('#new_password').val();
                var confirmed_password  = $('#confirmed_password').val();

                console.log('passowrd'+password);
                console.log('new passowrd'+new_password);
                console.log('confirm passowrd'+confirmed_password);
                

                if(password !== ''  || new_password !== '' || confirmed_password !== '' )
                {
                  
                  if( new_password === '' || confirmed_password === '' )
                    {
                      $('#passwordError').html('<div class="alert alert-warning">Fill All Pasword Fields</div>');
                      e.preventDefault();
                    }
                    else if( password === '' || confirmed_password === '' )
                    {
                      $('#passwordError').html('<div class="alert alert-warning">Fill All Pasword Fields</div>');
                      e.preventDefault();
                    }
                    else
                    {
                      if (new_password !== confirmed_password) 
                        {
                            $('#passwordError').html('<div class="alert alert-warning">New & Confirmed Password Mismatched</div>');
                            e.preventDefault();
                        } else {
                            $('#passwordError').html('');
                        }
                    }
                }
                else
                {
                  $('#passwordError').html('');
                }
                
            
            });


    });
  </script>


@endsection
