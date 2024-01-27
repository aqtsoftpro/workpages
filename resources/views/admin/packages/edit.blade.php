@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Edit Package</li>
                <li class="breadcrumb-item active">{{ $record->name }}</li>
            </ol>
        </nav>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <div class="alert alert-success d-none" id="j_alert"></div>
    <div class="alert alert-danger d-none" id="j_alert_danger"></div>
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
                                    <a href="{{ url('admin/subscriptions') }}" class="btn btn-success">View all</a>
                                    <a href="{{ url('admin/subscriptions/create') }}" class="btn btn-success">Add new</a>
                                </div>
                            </div>
                        </h5>

                        <form id="main-form" method="POST" action="{{ route('packages.update', $record->id) }}"
                            class="row g-3">

                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ $record->name }}" class="form-control"
                                    id="social_media_facebook">
                            </div>
                            <div class="col-md-12">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" name="price" value="{{ $record->price }}" class="form-control"
                                    id="price" required>
                            </div>

                            <br>
                            <br><br>
                            <div class="card-title mt-5">
                                Add More Key Points...
                            </div>

                            <div id="dynamic-fields">
                                @foreach ($record->keypoints as $point)
                                    <div class="row field">
                                        <div class="col-md-3">
                                            <label for="icon" class="form-label">Icon </label>
                                            <input type="text" name="icon[]" value="{{ old('icon', $point->icon) }}"
                                                class="form-control" placeholder="e.g. fa fa-tick..." id="icon"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="title" class="form-label">Title </label>
                                            <input type="text" name="title[]" value="{{ old('title', $point->title) }}"
                                                class="form-control" placeholder="e.g. title..." id="title">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="detail" class="form-label">Detail </label>
                                            <input type="text" name="detail[]"
                                                value="{{ old('detail', $point->detail) }}" class="form-control"
                                                placeholder="e.g. detail..." id="detail" required>
                                        </div>
                                        <div class="col-md-1 mt-3">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModel-{{ $point->id }}"
                                                class="btn btn-primary mt-3"><i class="bi bi-trash"></i></button>
                                        </div>

                                        <div class="modal fade" id="deleteModel-{{ $point->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Point</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure You want to Delete <b>{{ $point->title }}</b>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form id="delete-form" class="form-delete"
                                                            action="{{ route('keypoints.destroy', $point->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger delete-button">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>

                            <div class="col-12 my-5">
                                <button class="btn btn-primary float-end" type="button" id="add-more">Add More</button>
                            </div>

                            <div>
                                <button type="submit" id="main-button" class="btn btn-primary">Update</button>
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
                                      <label for="icon" class="form-label">Icon </label>
                                      <input type="text" name="icon[]" value="{{ old('icon') }}" class="form-control"
                                          placeholder="e.g. fa fa-tick..." id="icon" required>
                                  </div>
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
                                      <button type="button" class="remove-field btn btn-primary mt-3" ><i class="bi bi-trash"></i></button>
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

        $(document).ready(function() {
            // Handle each form individually
            $(".delete-button").click(function() {
                $(this).closest("form").submit();
            });
        });

        $(document).ready(function() {
            $("#main-button").click(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Get the form action URL
                var formAction = $("#main-form").attr("action");

                // Serialize form data
                var formData = $("#main-form").serialize();

                // Submit the form using AJAX
                $.ajax({
                    type: "PUT",
                    url: formAction,
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {

                            var alertElement = $('#j_alert');
                            alertElement.html(`<p>${response.message}</p>`);
                            alertElement.hide().removeClass('d-none').fadeIn();

                            // Fade out after a certain duration (e.g., 3000 milliseconds or 3 seconds)
                            setTimeout(function() {
                                alertElement.fadeOut();
                                window.location.reload();
                            }, 3000);

                        } else {

                            var errorElement = $('#j_alert_danger');
                            errorElement.html(`<p>${response.message}</p>`);
                            errorElement.hide().removeClass('d-none').fadeIn();

                            // Fade out after a certain duration (e.g., 3000 milliseconds or 3 seconds)
                            setTimeout(function() {
                                errorElement.fadeOut();
                            }, 3000);
                        }
                    },
                    error: function(error) {
                        // Handle error if needed
                        console.error(error);
                    }
                });
            });
        });


        // console.log("Outer Form Submitted!");
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
