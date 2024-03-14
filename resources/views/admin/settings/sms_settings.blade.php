@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>SMS Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">SMS Settings</li>
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
            <h5 class="card-title">Twilio Settings</h5>

            <form class="row g-3" action="{{ url('admin/settings/update_main_settings/')  }}" method="POST">
                @csrf
                <input type="hidden" name="setting_form_type" value="twilio_settings" >
                <div class="col-md-12">
                  <label for="twilio_account_sid" class="form-label">Account SID</label>
                  <input type="text" name="setting[_twilio_account_sid]" value="{{ (isset($settings['_twilio_account_sid']['meta_val']))? $settings['_twilio_account_sid']['meta_val']:'' }}" class="form-control" id="twilio_account_sid">
                </div>
                <div class="col-md-12">
                  <label for="twilio_account_auth_token" class="form-label">Auth Token</label>
                  <input type="text" name="setting[_twilio_account_auth_token]" value="{{ (isset($settings['_twilio_account_auth_token']['meta_val']))? $settings['_twilio_account_auth_token']['meta_val']:'' }}" class="form-control" id="twilio_account_auth_token">
                </div>
                {{-- <div class="col-md-12">
                  <label for="twilio_service_id" class="form-label">Service ID</label>
                  <input type="text" name="setting[_twilio_service_id]" value="{{ (isset($settings['_twilio_service_id']['meta_val']))? $settings['_twilio_service_id']['meta_val']:'' }}" class="form-control" id="twilio_service_id">
                </div> --}}
                <div class="col-md-12">
                  <label for="twilio_number" class="form-label">Twilio Number</label>
                  <input type="text" name="setting[_twilio_number]" value="{{ (isset($settings['_twilio_number']['meta_val']))? $settings['_twilio_number']['meta_val']:'' }}" class="form-control" id="twilio_number">
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
