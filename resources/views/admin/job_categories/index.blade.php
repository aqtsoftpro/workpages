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
            <h5 class="card-title row">
              <div class="col-lg-6">
                View Job Categories
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/job_categories/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
         
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                {{-- <th scope="col">Image</th>
                <th scope="col">Available Job</th>
                <th scope="col">Application</th> --}}
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($records as $record)
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $record->name }}</td>
                  @php
                    if($record->image)
                      {
                        $image = $record->image;
                      }
                      else 
                      {
                        $image = env('APP_URL').'/NiceAdmin/assets/img/no-image.jpg';
                      }
                  @endphp
                  {{-- <td><img src="{{ $image }}" width="50" height="50"/></td>
                  <td></td>
                  <td></td> --}}
                  <td>
                    @if( $record->status == 'enable')
                      <i class="bi bi-check text-green" style="font-size: 20px; font-weight:bold;"></i>
                    @else
                      <i class="bi bi-x  text-danger" style="font-size: 20px; font-weight:bold;"></i>
                    @endif
                  </td>
                  <td>
                      <a class="mx-1 text-success" href="{{ route('job_categories.edit', $record->id) }}"><i class="bi bi-pen"></i> </a>|
                      <a type="#" class="mx-1 text-danger" data-name="Job Category" data-bs-toggle="modal" data-bs-target="#deleteModel-{{ $record->id }}" data-msg="" data-url=""><i class="bi bi-trash"></i></a>


                      <div class="modal fade" id="deleteModel-{{ $record->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Job Category</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure You want to Delete <b>{{ $record->name }}</b>?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form id="delete-form" action="{{ route('job_categories.destroy', $record->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>

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
