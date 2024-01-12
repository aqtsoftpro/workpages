@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Manage Applications</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Jobs</li>
        <li class="breadcrumb-item active">Manage Applications</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Job Applications</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Company</th>
                        <th>Job Title</th>
                        <th>Salary Range</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->user->name }}</td>
                            <td>{{ $application->company->name }}</td>
                            <td>{{ $application->job->job_title }}</td>
                            <td>{{ $application->job->currency->symbol . ' ' . $application->job->salary_from . ' - ' . $application->job->currency->symbol . ' ' . $application->job->salary_to }}</td>
                            <td>{{ $application->status->name }}</td>
                            {{--  <td>
                                <form method="POST" action="{{ url('/admin/jobs/change_status')}}">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                                    <select name="status" class="form-select">
                                        <option {{ ($job->status == 'active') ? 'selected' : '' }}>active</option>
                                        <option {{ ($job->status == 'inactive') ? 'selected' : '' }}>inactive</option>
                                    </select>
                                    <button class="btn btn-primary" type="submit">change status</button>
                                </form
                            </td>  --}}
                        <tr>
                    @endforeach
                </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
