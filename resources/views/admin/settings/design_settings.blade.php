@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Design Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Design Settings</li>
      </ol>
    </nav>
  </div>
  @php
    // echo "<pre>";
    // print_r($settings);
    // echo "</pre>";
    // echo $settings['_site_logo']['meta_val'];
  @endphp

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
            <form method="POST"  action="{{ url('admin/settings/update_main_settings/')  }}" enctype="multipart/form-data">
              {{-- @method('PUT') --}}
                @csrf
            <input type="hidden" name="setting_form_type" value="design_settings" >
            <h1 class="card-title mb-0">Logo</h1>
            <hr class="mt-0">
            <div class="row">
              <div class="col-md-6 mb-2">
                <label for="site_logo" class="form-label">Site Logo</label>
                <input type="file" name="_site_logo" value="" class="form-control" id="site_logo">
              </div>
              <div class="col-md-6 mb-2">

                @if (isset($settings['_site_logo']['meta_val']) && $settings['_site_logo']['meta_val'])
                  @php
                    $site_logo_img  = $settings['_site_logo']['meta_val'];
                  @endphp
                  <div class="admin-manage-img-container">
                  <i class="bi bi-x-octagon-fill delete-img-btn delete-site-logo-btn"></i>
                  <img src="{{ $site_logo_img }}" width="150" height="150" />
                  <input type="hidden" name="setting[_site_logo]" value="{{ (isset($settings['_site_logo']['meta_val']))? $settings['_site_logo']['meta_val']:'' }}" class="form-control" id="exist_site_logo">
                  </div>
                @endif

              </div>
              <hr>
              <div class="col-md-6 mb-2">
                <label for="site_logo" class="form-label">Site Favicon</label>
                <input type="file" name="_site_favicon" value="" class="form-control" id="site_favicon">
              </div>
              <div class="col-md-6 mb-2">
                
                @if (isset($settings['_site_favicon']['meta_val']) && $settings['_site_favicon']['meta_val'])
                  @php
                    $site_favicon_img  = $settings['_site_favicon']['meta_val'];
                  @endphp
                  <div class="admin-manage-img-container">
                  <i class="bi bi-x-octagon-fill delete-img-btn delete-site-logo-btn"></i>
                  <img src="{{ $site_favicon_img }}" width="150" height="150" />
                  <input type="hidden" name="setting[_site_favicon]" value="{{ (isset($settings['_site_favicon']['meta_val']))? $settings['_site_favicon']['meta_val']:'' }}" class="form-control" id="exist_admin_img">
                  </div> 
                @endif

              </div>
            </div>
             <h1 class="card-title mb-0">Colors</h1>
            <hr class="mt-0">
            <b class="col-md-12 mb-4">Site Colors</b>
            <div class="row">
              <div class="col-md-3 mb-2">
                <label for="site_base_color_1" class="form-label">Base Color 1</label><br>
                <input type="color" name="setting[_site_base_color_1]" class="form-control form-control-color" value="{{ (isset($settings['_site_base_color_1']['meta_val']))? $settings['_site_base_color_1']['meta_val']:'' }}"  id="site_base_color_1">
              </div>
              <div class="col-md-3 mb-2">
                <label for="site_base_color_2" class="form-label">Base Color 2</label><br>
                <input type="color" name="setting[_site_base_color_2]" class="form-control form-control-color" value="{{ (isset($settings['_site_base_color_2']['meta_val']))? $settings['_site_base_color_2']['meta_val']:'' }}"  id="site_base_color_2">
              </div>
              <div class="col-md-3 mb-3">
                <label for="site_base_color_3" class="form-label">Base Color 3</label><br>
                <input type="color" name="setting[_site_base_color_3]" class="form-control form-control-color" value="{{ (isset($settings['_site_base_color_3']['meta_val']))? $settings['_site_base_color_3']['meta_val']:'' }}"  id="site_base_color_1">
              </div>
            </div>
{{--
            <h5 class="card-title mb-0">Colors</h5>
            <h5 class="card-title mb-0">Fonts</h5>
            <hr class="mt-0">
            <h5 class="card-title mb-0">Icons</h5>
            <hr class="mt-0">
            <h5 class="card-title mb-0">Forms</h5>
            <h5 class="card-title mb-0">Header</h5>
            <h5 class="card-title mb-0">Footer</h5> --}}


                    {{-- <table class="table">
                        <tr>
                            <td>Support Line</td>
                            <td>
                                <input class="form-control" type="text" name="support_line" value="{{ $globalSettings['support_line']}}" />
                            </td>
                        </tr>
                    </table> --}}
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
