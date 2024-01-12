@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Slider Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Slider Settings</li>
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
            <form method="POST"  action="{{ url('admin/settings/update_main_settings/')  }}" enctype="multipart/form-data">
                @csrf
            <input type="hidden" name="setting_form_type" value="slider_settings" >
            <h1 class="card-title mb-0">Slider Settings</h1>
            <hr class="mt-0">
            <div class="row">
              <div class="col-md-6 mb-2">
                <label for="_slider_img" class="form-label">Slider Image Logo</label>
                <input type="file" name="_slider_img" value="{{ (isset($settings['_slider_img']['meta_val']))? $settings['_site_logo']['meta_val']:'' }}" class="form-control" id="_slider_img">
              </div>
              <div class="col-md-6 mb-2 mt-2">
                @if (isset($settings['_slider_img']['meta_val']) && $settings['_slider_img']['meta_val'])
                  @php
                    $site_slider_img  = $settings['_slider_img']['meta_val'];
                  @endphp
                  <div class="admin-manage-img-container">
                  <i class="bi bi-x-octagon-fill delete-img-btn delete-site-logo-btn"></i>
                  <img src="{{ $site_slider_img }}" width="100%"  />
                  <input type="hidden" name="setting[_slider_img]" value="{{ (isset($settings['_slider_img']['meta_val']))? $settings['_slider_img']['meta_val']:'' }}" class="form-control" id="exist_site_logo">
                  </div>  
                @endif
   
              </div>
              
              <hr>
              
            </div>
            <div class="row">
              <div class="col-md-12 mb-2">
                <label for="_slider_content" class="form-label">Slider Content</label><br>
                <textarea name="setting[_slider_content]" class="form-control" id="_slider_content" style="height: 100px">{{ (isset($settings['_slider_content']['meta_val']))? $settings['_slider_content']['meta_val']:'' }}</textarea>
              </div>

              <div class="col-md-12 mb-2">
                <hr>
                <label for="_search_panel_margin_top" class="form-label">Search Panel Margin Top</label>
                <input type="text" name="setting[_search_panel_margin_top]" value="{{ (isset($settings['_search_panel_margin_top']['meta_val']))? $settings['_search_panel_margin_top']['meta_val']:'' }}" class="form-control" id="_search_panel_margin_top">
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
