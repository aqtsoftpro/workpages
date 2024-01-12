@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Social Media Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Social Media Settings</li>
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
            <h5 class="card-title"></h5>

                <form method="POST"  action="{{ url('admin/settings/update_main_settings/')  }}" class="row g-3" >
                    {{-- @method('PUT') --}}
                    @csrf
                    <input type="hidden" name="setting_form_type" value="social_media_settings" >
                    <div class="col-md-12">
                      <label for="social_media_facebook" class="form-label">Facebook</label>
                      <input type="url" name="setting[_social_media_facebook]" value="{{ (isset($settings['_social_media_facebook']['meta_val']))? $settings['_social_media_facebook']['meta_val']:'' }}" class="form-control" id="social_media_facebook">
                    </div>
                    <div class="col-md-12">
                      <label for="social_media_twitter" class="form-label">Twitter</label>
                      <input type="url" name="setting[_social_media_twitter]" value="{{ (isset($settings['_social_media_twitter']['meta_val']))? $settings['_social_media_twitter']['meta_val']:'' }}" class="form-control" id="social_media_twitter">
                    </div>
                    <div class="col-md-12">
                      <label for="social_media_linkedin" class="form-label">LinkedIn</label>
                      <input type="url" name="setting[_social_media_linkedin]" value="{{ (isset($settings['_social_media_linkedin']['meta_val']))? $settings['_social_media_linkedin']['meta_val']:'' }}" class="form-control" id="social_media_linkedin">
                    </div>
                    <div class="col-md-12">
                      <label for="social_media_instagram" class="form-label">Instagram</label>
                      <input type="url" name="setting[_social_media_instagram]" value="{{ (isset($settings['_social_media_instagram']['meta_val']))? $settings['_social_media_instagram']['meta_val']:'' }}" class="form-control" id="social_media_instagram">
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
@endsection
