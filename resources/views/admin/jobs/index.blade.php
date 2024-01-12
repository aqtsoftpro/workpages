@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Jobs</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Jobs</li>
      <li class="breadcrumb-item active">Jobs</li>
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
                View Jobs
              </div>
              <div class="col-lg-6">
                
              </div>
            </h5>
         
          <!-- Table with stripped rows -->
          <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100 active" id="open-jobs-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">Current Jobs</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100" id="closed-jobs-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Expired Jobs</button>
            </li>
          </ul>
          <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="open-jobs-tab">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Location</th>
                    <th scope="col">Company</th>
                    <th scope="col">Salary Range</th>
                    <th scope="col">Expire Date</th>
                    <th scope="col">Publish Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($records_opened as $record)
                  <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>{{ $record->job_title }}</td>
                      <td>{{ $record->location->name }}</td>
                      <td>{{ $record->company->name }}</td>
                      <td>{{ $record->currency->symbol . ' ' . $record->salary_from . ' - ' . $record->currency->symbol . ' ' . $record->salary_to }}</td>
                      <td>{{  date('F j, Y', strtotime($record->expiration)) }}</td>
                      <td>
                        @if( $record->status == 'active')
                          <i class="bi bi-check text-green" style="font-size: 20px; font-weight:bold;"></i>
                        @else
                          <i class="bi bi-x  text-danger" style="font-size: 20px; font-weight:bold;"></i>
                        @endif
                      </td>
                      <td>
                          <a class="mx-1 text-success" href="{{ route('jobs.edit', $record->id) }}"><i class="bi bi-pen"></i> </a>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
            <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="closed-jobs-tab">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Location</th>
                    <th scope="col">Company</th>
                    <th scope="col">Salary Range</th>
                    <th scope="col">Expire Date</th>
                    <th scope="col">Publish Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($records_closed as $record)
                  <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>{{ $record->job_title }}</td>
                      <td>{{ $record->location->name }}</td>
                      <td>{{ $record->company->name }}</td>
                      <td>{{ $record->currency->symbol . ' ' . $record->salary_from . ' - ' . $record->currency->symbol . ' ' . $record->salary_to }}</td>
                      <td>{{  date('F j, Y', strtotime($record->expiration)) }}</td>
                      <td>
                        @if( $record->status == 'active')
                          <i class="bi bi-check text-green" style="font-size: 20px; font-weight:bold;"></i>
                        @else
                          <i class="bi bi-x  text-danger" style="font-size: 20px; font-weight:bold;"></i>
                        @endif
                      </td>
                      <td>
                          <a class="mx-1 text-success" href="{{ route('jobs.edit', $record->id) }}"><i class="bi bi-pen"></i> </a>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div><!-- End Bordered Tabs Justified -->



      

          </div>
        </div>

      </div>
    </div>
  </section>




@endsection
