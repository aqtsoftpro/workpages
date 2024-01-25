@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Job Seeker</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Job Seeker</li>
                <li class="breadcrumb-item active">{{ $record->name }}</li>
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
                                Edit {{ $record->name }}
                            </div>
                            <div class="col-lg-6">
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <a href="{{ url('admin/job_seekers') }}" class="btn btn-success">View all</a>
                                </div>
                            </div>
                        </h5>


                        <div class="col-md-12">
                            <label for="name" class="form-label"><b>Name</b></label><br>
                            {{ $record->name }}
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <label for="email" class="form-label"><b>Email</b></label><br>
                            {{ $record->email }}
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <label for="email" class="form-label"><b>Suburb</b></label><br>
                            @php
                                $suburb = DB::table('suburbs')
                                    ->where('id', $record->suburb_id)
                                    ->first();
                            @endphp
                            {{ $suburb ? $suburb->name : '' }}
                        </div>

                        <hr>
                        <div class="col-md-12">
                            <label for="email" class="form-label"><b>Phone</b></label><br>
                            {{ $record->phone }}
                        </div>

                        <hr>
                        <div class="col-md-12">
                            <label for="email" class="form-label"><b>Description</b></label><br>
                            {{ $record->phone }}
                        </div>

                        {{-- <hr>
                        <div class="col-md-12">
                            <label for="email" class="form-label"><b>Location</b></label><br>
                            {{ $record->location }}
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
