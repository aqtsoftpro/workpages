@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Banner Settings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Banner Settings</li>
            </ol>
        </nav>
    </div>
    @php
        // echo "<pre>";
        // print_r($settings);
        // echo "</pre>";
        // echo $settings['_site_logo']['meta_val'];
    @endphp
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/settings/update_main_settings/') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="setting_form_type" value="banner_settings">
                            <h1 class="card-title mb-0">Banner Settings</h1>
                            <hr class="mt-0">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="_back_image" class="form-label">Banner Image</label>
                                    <input type="file" name="_back_image" class="form-control" id="_back_image">
                                </div>
                                <div class="col-md-6 mb-2 mt-2">
                                    {{-- {{ json_encode($settings) }} --}}
                                    @if (isset($settings['_banner_image']['meta_val']) && $settings['_banner_image']['meta_val'])
                                        @php
                                            $site_banner_image = $settings['_banner_image']['meta_val'];
                                        @endphp
                                        <div class="admin-manage-img-container">
                                            <i class="bi bi-x-octagon-fill delete-img-btn delete-site-logo-btn"></i>
                                            <img src="{{ $site_banner_image }}" width="100%" />
                                        </div>
                                    @endif
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="_banner_text_color" class="form-label">Banner Content Color</label>
                                    <input type="color" name="setting[_banner_text_color]"
                                        value="{{ isset($settings['_banner_text_color']['meta_val']) ? $settings['_banner_text_color']['meta_val'] : '#010536' }}"
                                        class="form-control" id="_banner_text_color" style="height: 2.5rem !important">
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <script type="">
    $(document).ready(function() 
    {

      $(".delete-site-logo-btn").click(function(){
        $(this).parent().hide();
        $(this).parent().find("input").val('')
      });

    });
  </script>
@endsection
