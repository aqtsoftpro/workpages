@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Subscriptions</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Subscriptions</li>
      <li class="breadcrumb-item active">Subscriptions</li>
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
                View Subscriptions
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/subscriptions/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
         
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Subcriber Information</th>
                <th scope="col">Package</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($records as $record)
              @php
                // echo "<pre>";
                // print_r($record->user);
                // echo "</pre>";

              @endphp
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $record->user->name }}<br>
                   <b>Company</b> {{ $record->company->name }}
                  </td>
                  <td>{{ $record->package->name }}
                  
                  </td>
                  <td>{{ $record->created_at }}</td>
                  <td>
                      <a class="mx-1 text-success" href="{{ route('subscriptions.edit', $record->id) }}"><i class="bi bi-pen"></i> </a>|
                      <a type="#" class="mx-1 text-danger"  data-bs-toggle="modal" data-bs-target="#deleteModel-{{ $record->id }}" ><i class="bi bi-trash"></i></a>


                      <div class="modal fade" id="deleteModel-{{ $record->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Package</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure You want to Delete <b>{{ $record->name }}</b>?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form id="delete-form" action="{{ route('subscriptions.destroy', $record->id) }}" method="POST">
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
