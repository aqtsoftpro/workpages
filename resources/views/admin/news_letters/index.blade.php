@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Packages</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Packages</li>
                <li class="breadcrumb-item active">Packages</li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title row">
                            <div class="col-lg-6">
                                Select Contact List
                            </div>
                        </h5>
                        <form action="{{ route('news.letter') }}" method="get" class="row g-3" id="list-form">
                            <select class="form-select" id="list-id" name="list_id"> <!-- Added name attribute -->
                                <option selected>Select one</option>
                                @foreach ($list_ids as $item)
                                    <option value="{{ $item->meta_val }}">{{ $item->meta_val }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                {{-- <p>{{ json_encode($members) }}</p> --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title row">
                            <div class="col-lg-6">
                                View Packages
                            </div>
                            <div class="col-lg-6">
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <a href="{{ route('packages.create') }}" class="btn btn-success">Add new</a>
                                </div>
                            </div>
                        </h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Complete Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $member->full_name }}</td>
                                        <td>{{ $member->email_address }}</td>
                                        {{-- <td>

                                            <a class="mx-1 text-success"
                                                href="{{ route('packages.edit', $member->id) }}"><i
                                                    class="bi bi-pen"></i> </a>|
                                            <a type="#" class="mx-1 text-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModel-{{ $member->id }}"><i
                                                    class="bi bi-trash"></i></a>

                                            <div class="modal fade" id="deleteModel-{{ $member->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Package</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure You want to Delete <b>{{ $member->name }}</b>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <form id="delete-form"
                                                                action="{{ route('subscriptions.destroy', $member->id) }}"
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

                                        </td> --}}
                                        <td>
                                            <span
                                                class="badge p-2 {{ $member->status == 'subscribed' ? 'bg-success' : 'bg-danger' }}">{{ $member->status }}</span>
                                            {{-- <span class="badge" @class(['bg-success'=> $member->status == 'subscribed'])>{{ $member->status}}</span> --}}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-info dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    More
                                                </a>

                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('newsletter.status', ['status' => $member->status, 'hash' => $member->id]) }}">{{ $member->status == 'subscribed' ? 'Unsubscribe' : 'Subscribe' }}</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('newsletter.archive', ['status' => $member->status, 'hash' => $member->id]) }}">Archive</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('newsletter.permanent', ['status' => $member->status, 'hash' => $member->id]) }}">Delete
                                                            Permanently</a></li>
                                                </ul>
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
    <script>
        document.getElementById('list-id').addEventListener('change', function() {
            document.getElementById('list-form').submit();
        });
    </script>    
@endsection
