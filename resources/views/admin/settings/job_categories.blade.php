@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Job Categories</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Job Categories</li>
        <li class="breadcrumb-item active">Job Categories</li>
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
            <h5 class="card-title">View Job Categories</h5>

            {{-- <form method="POST" action={{ url('/admin/settings/create_job_category') }}>
                @csrf
                <div class="col-md-6">
                    <label for="inputName5" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <div class="col-md-6 mt-2">
                    <button class="btn btn-primary">Create Job Category</button>
                </div>
            </form> --}}


          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Available Job</th>
                <th scope="col">Application</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($job_categories as $job_category)
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $job_category->name }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                      <a style="float:left" class="btn btn-primary" href="{{ url('/admin/settings/edit_job_category' . '/' . $job_category->id) }}">Edit</a>
                      <form style="float:left; margin-left: 10px" method="POST" action="{{url('/admin/settings/delete_job_category' . '/' . $job_category->id) }}">
                          @csrf
                          <input type="hidden" name="job_category_id" value="{{ $job_category->id }}" />
                          <button class="btn btn-danger" type="submit" href="#">Delete</button>
                      </form>

                      <a href="http://localhost/leprosycms/public/provinces/4/edit"><i class="bi bi-edit text-success mx-1"></i></a>
                      <a type="click" class="delete-rec-btn mx-1 text-danger" data-name="province" data-msg="Are you sure You want to Delete <b>Balochistan</b>?" data-url="http://localhost/leprosycms/public/provinces/4"><i class="fa fa-trash-o"></i></a>

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
