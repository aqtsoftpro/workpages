@extends('layouts.app')

{{-- ck ck-content ck-editor__editable ck-rounded-corners ck-editor__editable_inline ck-blurred --}}
<link rel="stylesheet" href="http://localhost:8080/assets/css/boxicons.min.css">
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
                <li class="breadcrumb-item active">Edit Package</li>
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
                                Edit Package
                            </div>
                            <div class="col-lg-6">
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <a href="{{ url('admin/packages') }}" class="btn btn-success">View all</a>
                                </div>
                            </div>
                        </h5>

                        <form method="POST" action="{{ route('packages.update', $record->id) }}" class="row g-3">
                            @csrf
                            @method('PUT')

                            <div class="card-title mt-5">
                                Allow permissions:
                            </div>

                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_ads" id="allow_ads" value="{{$record->allow_ads ?? null}}"
                                    label="Allow unlimited ads to post" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_edits" id="allow_edits" value="{{$record->allow_edits ?? null}}"
                                    label="Allow unlimited edits to post" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_ref" id="allow_ref" value="{{$record->allow_ref ?? null}}"
                                    label="Allow to verify work references" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_right" id="allow_right" value="{{$record->allow_right ?? null}}"
                                    label="Allow to verify work rights" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_others" id="allow_others" value="{{$record->allow_others ?? null}}"
                                    label="Allow to verify other documents" />
                            </div>

                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="h_s_screen" id="h_s_screen" value="{{$record->h_s_screen ?? null}}"
                                    label="Health and safety screening permission" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="allow_interview" id="allow_interview" value="{{$record->allow_interview ?? null}}"
                                    label="Allow to jobseeker interview" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="recruiter_dash" id="recruiter_dash" value="{{$record->recruiter_dash ?? null}}"
                                    label="Access to recruiter dashboard" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="casual_portal" id="casual_portal" value="{{$record->casual_portal ?? null}}"
                                    label="Access to our casual PORTAL" />
                            </div>
                            <div class="col-md-3">
                                <x-package.dropdown :boolean="true" name="rec_support" id="rec_support" value="{{$record->rec_support ?? null}}"
                                    label="Dedicated recruitment support" />
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="cv_access"
                                        value="1" id="cv_access" @checked($record->cv_access == 1)>
                                    <label class="form-check-label" for="cv_access">CV access</label>
                                </div>
                            </div>

                            <div class="col-md-3" id="cvCredits" style="display: none;">
                                <label for="cv_credit" class="form-label">CV download credits</label>
                                <input type="number" name="cv_credit" value="{{ $record->cv_credit }}" class="form-control"
                                    placeholder="must in integer" id="cv_credit" required>
                            </div>


                            <div class="col-md-3">
                                <label for="msg_credit" class="form-label">Message credits</label>
                                <input type="number" name="msg_credit" value="{{ $record->msg_credit }}" class="form-control"
                                    placeholder="must in number" id="msg_credit" required>
                            </div>

                            <div class="col-md-3">
                                <x-package.dropdown name="post_for" id="post_for" :value="null" label="Ads run with days">
                                    <option value="15" @selected($record->post_for == 15 )>15 Days</option>
                                    <option value="30" @selected($record->post_for == 30 )>30 Days</option>
                                    <option value="45" @selected($record->post_for == 45 )>45 Days</option>
                                    <option value="60" @selected($record->post_for == 60 )>60 Days</option>
                                    <option value="90" @selected($record->post_for == 90 )>90 Days</option>
                                </x-package.dropdown>
                            </div>

                            <br><br>
                            <div class="card-title mt-5">
                                Add More Key Points...
                            </div>

                            <div id="dynamic-fields">
                                {{-- <div class="row field">

                                    <div class="col-md-3">
                                        <x-common.icon-list name="icon[]" id="icon-1" :value="null" label="Icon" />
                                    </div>
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
                                </div> --}}
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end" type="button" id="add-more">Add More</button>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

                                        {{-- @foreach ($record?->keypoints as $point)
                                    <div class="row field">
                                        <div class="col-md-3">
                                            <label for="title" class="form-label">Title </label>
                                            <input type="text" name="title[]" value="{{ old('title', $point->title) }}"
                                                class="form-control" placeholder="e.g. title..." id="title">
                                        </div>
                                        <div class="col-md-7">
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
                                @endforeach --}}
    </section>


    <!-- Add this script section at the end of your Blade file or in a separate JavaScript file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var moreFields = `
                            <div class="row field">
                                <div class="col-md-3">
                                    <x-common.icon-list name="icon[]" id="icon-1" :value="null" label="Icon" />
                                </div>
                                <div class="col-md-3">
                                    <label for="title" class="form-label">Title </label>
                                    <input type="text" name="title[]" value="{{ old('title') }}" class="form-control"
                                        placeholder="e.g. title..." id="title" >
                                </div>

                                <div class="col-md-1 mt-3">
                                    <button type="button" class="remove-field btn btn-primary mt-3" >remove</button>
                                </div>
                            </div>`

                            // <div class="col-md-5">
                            //         <label for="detail" class="form-label">Detail </label>
                            //         <input type="text" name="detail[]" value="{{ old('detail') }}" class="form-control"
                            //             placeholder="e.g. detail..." id="detail" required>
                            //     </div>
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
            $('#cv_access').change(function() {
                if ($(this).is(':checked')) {
                    $('#cvCredits').show();
                } else {
                    $('#cvCredits').hide();
                }
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
