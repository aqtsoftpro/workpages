@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Notification Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Notification Settings</li>
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
            <h5 class="card-title">Notification Settings</h5>

            {{-- <select class="form-select col-md-6"  name="payment_gateway_name">
                <option value="1">Stripe</option>
            </select> --}}

            <form class="row g-3" action="{{ url('admin/settings/update_main_settings/')  }}" method="POST">
                @csrf
                <input type="hidden" name="setting_form_type" value="notification_settings" >

                <!-- Default Tabs -->
                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="_notification_newsletter" id="flexSwitchCheckChecked" {{ (isset($settings['_notification_newsletter']['meta_val']) && $settings['_notification_newsletter']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Newsletter</label>
                  </div>
                  <hr>
                </div>
                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="_notification_job_activity" id="flexSwitchCheckChecked" {{ (isset($settings['_notification_job_activity']['meta_val']) && $settings['_notification_job_activity']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Job Activity</label>
                  </div>
                  <hr>
                </div>
                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="_notification_package_subscription" id="flexSwitchCheckChecked" {{ (isset($settings['_notification_package_subscription']['meta_val']) && $settings['_notification_package_subscription']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Package Subscription</label>
                  </div>
                  <hr>
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
