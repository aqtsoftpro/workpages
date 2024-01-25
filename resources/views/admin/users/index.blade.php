@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Manage Job Seekers</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Site Users</li>
        <li class="breadcrumb-item active">Manage Job Seekers</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Job Seekers</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($job_seekers as $job_seeker)
                        <tr>
                            <td>{{ $job_seeker->name }}</td>
                            <td>{{ $job_seeker->email }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('users.edit', $job_seeker->id) }}">Edit</a>
                                <a class="btn btn-info" href="#">View</a>
                                <a class="btn btn-danger" href="#">Delete</a>
                            </td>
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
