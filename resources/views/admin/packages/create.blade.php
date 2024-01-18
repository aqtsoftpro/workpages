@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Package</li>
                <li class="breadcrumb-item active">Add Package</li>
            </ol>
        </nav>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script> --}}

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title row">
                            <div class="col-lg-6">
                                Add Package
                            </div>
                            <div class="col-lg-6">
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <a href="{{ url('admin/subscriptions') }}" class="btn btn-success">View all</a>
                                </div>
                            </div>
                        </h5>


                        <form method="POST" action="{{ route('packages.store') }}" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" name="price" value="{{ old('price') }}" class="form-control"
                                    id="price" required>
                            </div>

                            <div class="col-md-6">
                                <label for="interval" class="form-label">Interval</label>
                                <select name="interval" id="" class="form-select">
                                    <option value="day">Days</option>
                                    <option value="month">Months</option>
                                    <option value="year">Years</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="interval_count" class="form-label">Interval Count</label>
                                <input type="number" name="interval_count" value="" class="form-control"
                                    id="interval_count" required>
                            </div>

                            <div class="col-md-6">
                                <label for="design" class="form-label">Designation </label>
                                <input type="text" name="design" value="{{ old('design') }}" class="form-control" placeholder="e.g. Job"
                                    id="design" required>
                            </div>

                            <div class="col-md-6">
                                <label for="count" class="form-label">Count </label>
                                <input type="number" name="count" value="" class="form-control" placeholder="e.g. count..."
                                    id="count" required>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description </label>
                                <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script> --}}
@endsection
