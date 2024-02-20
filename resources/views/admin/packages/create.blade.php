@extends('layouts.app')

{{-- ck ck-content ck-editor__editable ck-rounded-corners ck-editor__editable_inline ck-blurred --}}

<style>
    .ck-editor__editable {
        height: 300px !important;
    }
</style>
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

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

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
                                <input type="text" name="design" value="{{ old('design') }}" class="form-control"
                                    placeholder="e.g. Job" id="design" required>
                            </div>

                            <div class="col-md-6">
                                <label for="count" class="form-label">Count </label>
                                <input type="number" name="count" value="" class="form-control"
                                    placeholder="e.g. count..." id="count" required>
                            </div>

                            <div class="col-md-6">
                                <label for="main_icon" class="form-label">Main Icon </label>
                                <input type="text" name="main_icon" value="{{ old('main_icon') }}" class="form-control"
                                    placeholder="e.g. fa fa-link or image path..." id="main_icon" required>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description </label>
                                <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                            </div>
                            <br>
                            <br><br>
                            <div class="card-title mt-5">
                                Add More Key Points...
                            </div>

                            <div id="dynamic-fields">
                                <div class="row field">
                                    {{-- <div class="col-md-3">
                                        <label for="icon" class="form-label">Icon </label>
                                        <input type="text" name="icon[]" value="{{ old('icon') }}"
                                            class="form-control" placeholder="e.g. fa fa-tick..." id="icon" required>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label for="title" class="form-label">Title </label>
                                        <input type="text" name="title[]" value="{{ old('title') }}"
                                            class="form-control" placeholder="e.g. title..." id="title">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="detail" class="form-label">Detail </label>
                                        <input type="text" name="detail[]" value="{{ old('detail') }}"
                                            class="form-control" placeholder="e.g. detail..." id="detail" required>
                                    </div>
                                    <div class="col-md-1 mt-3">
                                        <button type="button" class="remove-field btn btn-primary mt-3">remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end" type="button" id="add-more">Add More</button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Add this script section at the end of your Blade file or in a separate JavaScript file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var dynamicField =
                '<div class="field"><input type="text" name="icon[]" placeholder="Icon"> <input type="text" name="title[]" placeholder="Title"> <input type="text" name="detail[]" placeholder="Detail"> <button type="button" class="remove-field">Remove</button></div>';

            var moreFields = `
                            <div class="row field">
                                <div class="col-md-3">
                                    <label for="title" class="form-label">Title </label>
                                    <input type="text" name="title[]" value="{{ old('title') }}" class="form-control"
                                        placeholder="e.g. title..." id="title" >
                                </div>
                                <div class="col-md-5">
                                    <label for="detail" class="form-label">Detail </label>
                                    <input type="text" name="detail[]" value="{{ old('detail') }}" class="form-control"
                                        placeholder="e.g. detail..." id="detail" required>
                                </div>
                                <div class="col-md-1 mt-3">
                                    <button type="button" class="remove-field btn btn-primary mt-3" >remove</button>
                                </div>
                            </div>`
            // Add more fields
            $("#add-more").click(function() {
                $("#dynamic-fields").append(moreFields);
            });

            // Remove a specific field
            $("#dynamic-fields").on("click", ".remove-field", function() {
                $(this).parent().parent().remove();
            });
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
