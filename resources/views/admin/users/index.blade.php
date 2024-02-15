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
                                            <a class="mx-1 text-success"
                                                href="{{ route('users.edit', $job_seeker->id) }}"><i class="bi bi-pen"></i>
                                            </a>|
                                            @if (!$job_seeker->hasRole('Super Admin'))
                                                <a type="#" class="mx-1 text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModel-{{ $job_seeker->id }}"><i
                                                        class="bi bi-trash"></i></a>


                                                <div class="modal fade" id="deleteModel-{{ $job_seeker->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Users</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <tr>
                                        {{-- <tr>
                            <td>{{ $job_seeker->name }}</td>
                            <td>{{ $job_seeker->email }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('users.edit', $job_seeker->id) }}">Edit</a>
                                <a class="btn btn-info" href="#">View</a>
                                <a class="btn btn-danger" href="#">Delete</a>
                            </td>
                        <tr> --}}
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
