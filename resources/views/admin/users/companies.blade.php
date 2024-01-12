@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Manage Companies</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Site Users</li>
        <li class="breadcrumb-item active">Manage Companies</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Companies</h5>

            <table class="table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Owner</th>
                        <th>email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employers as $employer)
                        <tr>
                            <td>{{ $employer->company->name }}</td>
                            <td>{{ $employer->name }}</td>
                            <td>{{ $employer->email }}</td>
                            <td>
                                <a class="btn btn-primary" href="#">Edit</a>
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
