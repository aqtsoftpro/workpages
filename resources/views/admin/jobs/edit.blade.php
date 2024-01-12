@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Jobs</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Jobs</li>
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
                Edit {{ $record->job_title }}
              </div>
              <div class="col-lg-6 mb-5">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/jobs') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>
              <div class="row">
                <div class="col-md-3">
                  <b>Job Title</b>
                </div>
                <div class="col-md-3 border-end">
                  {{ $record->job_title }}
                </div>
                <div class="col-md-3">
                  <b>Job Type</b>
                </div>
                <div class="col-md-3">
                  {{ $record->job_type->name }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <b>Working Mode</b>
                </div>
                <div class="col-md-3 border-end"">
                  {{ $record->working_mode }}
                </div>
                <div class="col-md-3">
                  <b>Payment Mode</b>
                </div>
                <div class="col-md-3">
                  {{ $record->payment_mode }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <b>Qualification Required</b>
                </div>
                <div class="col-md-3 border-end"">
                  {{ $record->qualification->name }}
                </div>
                <div class="col-md-3">
                  <b>Gender Required</b>
                </div>
                <div class="col-md-3">
                  {{ $record->gender }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <b>Job Category</b>
                </div>
                <div class="col-md-6 border-end"">
                  {{ isset($record->category->name)?$record->category->name:'' }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 border-end">
                  <b>Job Description</b><br>
                  {{ $record->job_description }}
                </div>
                <div class="col-md-6">
                  <b>Job Responsibilities</b><br>
                  {{ $record->job_responsibilities }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <b>Vacancies</b>
                </div>
                <div class="col-md-3 border-end">
                  {{ $record->vacancy }}
                </div>
                <div class="col-md-3">
                  <b>Experience (Years)</b>
                </div>
                <div class="col-md-3">
                  {{ $record->experience }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <b>Salary (from)</b>
                </div>
                <div class="col-md-3 border-end">
                  {{ $record->salary_from }}
                </div>
                <div class="col-md-3">
                  <b>Salary (to)</b>
                </div>
                <div class="col-md-3">
                  {{ $record->salary_to }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <b>Job Expiery</b>
                </div>
                <div class="col-md-6 border-end"">
                  {{ date('F j, Y',strtotime($record->expiration)) }}
                </div>
                <div class="col-md-12">
                  <hr>
                </div>
              </div>
              <div class="row alert alert-info">
                <div class="col-md-6">
                  <b>Company Name</b>
                </div>
                <div class="col-md-6 border-end"">
                  {{ $record->company->name }}
                </div>
              </div>
                <form method="POST"  action="{{ route('jobs.update',$record->id) }}" class="row g-3" enctype="multipart/form-data">
                  
                  @csrf
                  @method('PUT')
                    
                    <div class="col-md-12">
                      <label for="social_media_linkedin" class="form-label">Status</label>
                      <select class="form-control" name="status">
                        <option value="active" {{ ( $record->status == 'active') ? 'selected' : '' }}>Enable</option>
                        <option value="inactive" {{ ( $record->status == 'inactive') ? 'selected' : '' }}>Disable</option>
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
