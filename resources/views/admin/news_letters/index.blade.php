@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>News Letters</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">News Letters</li>
                <li class="breadcrumb-item active">News Letters</li>
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
                                    <option value="{{ $item->meta_val }}" @selected($item->meta_val == $listId)>{{ $item->meta_val }}</option>
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
                        <div class="col-lg-6">
                            <h5 class="card-title row">
                                View Mail Chimps List
                            </h5>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ route('news.letter') }}" method="get" class="row g-3" id="list-form">
                                <select class="form-select" id="list-id" name="list_id"> <!-- Added name attribute -->
                                    <option selected>Select one</option>
                                    @foreach ($list_ids as $item)
                                        <option value="{{ $item->meta_val }}" @selected($item->meta_val == $listId)>{{ $item->meta_val }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
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
                                        <td>
                                            <span class="badge p-2 {{ $member->status == 'subscribed' ? 'bg-success' : 'bg-danger' }}">{{ $member->status }}</span>
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
