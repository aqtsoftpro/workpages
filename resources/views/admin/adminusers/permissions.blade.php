@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Manage Permissions</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Admin Users</li>
        <li class="breadcrumb-item active">Manage Permissions</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Permissions</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <td>
                                    <a class="btn btn-primary" href="#">Edit</a>
                                    <a class="btn btn-info" href="#">View</a>
                                    <a class="btn btn-danger" href="#">Delete</a>
                                </td>
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
