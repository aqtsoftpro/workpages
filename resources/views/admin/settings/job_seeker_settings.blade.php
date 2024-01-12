@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Portfolio Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Portfolio Settings</li>
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

                <form method="POST"  action="{{ url('admin/settings/update_main_settings/')  }}" class="row g-3">
        
                    @csrf
                    <input type="hidden" name="setting_form_type" value="job_seeker_settings" >
                    <div class="col-md-12">
                      <label for="site_name" class="form-label">Job Seeker Portfolio Count</label>
                      <input type="number" name="setting[_portfolio_count]" value="{{ (isset($settings['_portfolio_count']['meta_val']))? $settings['_portfolio_count']['meta_val']:'' }}" class="form-control" id="site_name">
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
