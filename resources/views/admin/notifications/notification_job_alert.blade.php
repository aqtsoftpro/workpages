@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Job Alert Notifications</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Job Alert Notifications</li>
      <li class="breadcrumb-item active">Job Alert Notifications</li>
    </ol>
  </nav>
</div>

  @if(session()->has('success'))
  <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error') }}</div>
@endif



  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title row">
              <div class="col-lg-6">
                Job Alert Notifications
              </div>
              <div class="col-lg-6">
         
              </div>
            </h5>
         
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Job ID</th>
                <th scope="col">Company Name</th>
                <th scope="col">Job Title</th>
                <th scope="col">Location</th>
                <th scope="col">Salary</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($records as $record)
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $record->job_id }}</td>
                  <td>{{ $record->company_name }}</td>
                  <td>{{ $record->job_title }}</td>
                  <td>{{ $record->location_id }}</td>
                  <td>
                    <b>Salary From : </b>{{ $record->salary_from }}<br>
                    <b>Salary To : </b>{{ $record->salary_to }}
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

      

          </div>
        </div>

      </div>
    </div>
  </section>




@endsection
