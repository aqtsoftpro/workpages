@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Companies</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Companies</li>
      <li class="breadcrumb-item active">Companies</li>
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
                View Companies
              </div>
              <div class="col-lg-6">
                
                <div class="btn-group  pr-1 float-end">

                    <select class="form-control" id="subrub_id">
                      
                        <option value="">Show All</option>
                      @foreach ($suburbs as $suburb)
                        <option value="{{ $suburb->id }}" {{ ($suburb->id == $get_suburb_id)?'selected':'' }}>{{ $suburb->name }}</option>
                      @endforeach
                 
                    </select>
                </div>
              </div>
            </h5>
         
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Jobs</th>
                <th scope="col">Suburb</th>
                <th scope="col">Joined</th>
                {{-- <th scope="col">Status</th> --}}
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($records as $record)
          
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{ $record->name }} 
                    <br>
                    <small>
                    <b>Owner :</b> {{ $record->name }}<br>
                    <b>email :</b> {{ $record->owner->email }}<br>
                    </small>
                  </td>
                  @php
                    if($record->logo)
                      {
                        $image = $record->logo;
                      }
                      else 
                      {
                        $image = env('APP_URL').'/NiceAdmin/assets/img/no-image.jpg';
                      }
                  @endphp
                  <td><img src="{{ $image }}" width="50" height="50"/></td>
                  <td>
                    <small>
                      <b>Job Created :</b> 3<br>
                      <b>Applications :</b> 4<br>
                    </small>
                  </td>
                  <td>{{ $record->suburb_id }}</td>
                  <td>{{ $record->created_at }}</td>
                  {{-- <td>
                    @if( $record->status == 'enable')
                      <i class="bi bi-check text-green" style="font-size: 20px; font-weight:bold;"></i>
                    @else
                      <i class="bi bi-x  text-danger" style="font-size: 20px; font-weight:bold;"></i>
                    @endif
                  </td> --}}
                  <td>
                      {{-- <a class="mx-1 text-success" href="{{ route('companies.edit', $record->id) }}"><i class="bi bi-pen"></i> </a>|  --}}
                      <a class="mx-1 text-success" href="{{ route('companies.show', $record->id) }}"><i class="bi bi-eye-fill"></i></a> 
                      {{-- |
                      <a type="#" class="mx-1 text-danger"  data-bs-toggle="modal" data-bs-target="#deleteModel-{{ $record->id }}" ><i class="bi bi-trash"></i></a> --}}


                      <div class="modal fade" id="deleteModel-{{ $record->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Delete Company</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure You want to Delete <b>{{ $record->name }}</b>?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form id="delete-form" action="{{ route('companies.destroy', $record->id) }}" method="POST">
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
