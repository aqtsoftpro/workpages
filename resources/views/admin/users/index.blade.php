



@extends('layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>Total Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Site Users</li>
                <li class="breadcrumb-item active">Manage Total Users</li>
            </ol>
        </nav>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title row">
                            <div class="col-lg-6">
                                Total user list
                            </div>

                        </h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($job_seekers as $job_seeker)
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $job_seeker->name }}</td>
                                    <td>{{ $job_seeker->email }}</td>

                                    <td>
                                        <a class="mx-1 text-success" href="{{ route('users.edit', $job_seeker->id) }}"><i
                                                class="bi bi-pen"></i>
                                        </a>|
                                        @if (!$job_seeker->hasRole('Super Admin'))
                                            <a type="#" class="mx-1 text-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModel-{{ $job_seeker->id }}"><i
                                                    class="bi bi-trash"></i></a>

                                            <div class="modal fade" id="deleteModel-{{ $job_seeker->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Users</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure You want to Delete
                                                            <b>{{ $job_seeker->name }}</b>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <form id="delete-form"
                                                                action="{{ route('users.destroy', $job_seeker->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
