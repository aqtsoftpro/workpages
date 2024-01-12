@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Newsletter Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Newsletter Settings</li>
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
            <h5 class="card-title">Mailchimp Settings</h5>

            <form class="row g-3" action="{{ url('admin/settings/update_main_settings/')  }}" method="POST">
                @csrf
                <input type="hidden" name="setting_form_type" value="mailchimp_settings" >
                <div class="col-md-12">
                  <label for="mailchimp_api_key" class="form-label">Mailchimp API Key</label>
                  <input type="text" name="setting[_mailchimp_api_key]" value="{{ (isset($settings['_mailchimp_api_key']['meta_val']))? $settings['_mailchimp_api_key']['meta_val']:'' }}" class="form-control" id="mailchimp_api_key">
                </div>
                <div class="col-md-12">
                  <label for="mailchimp_api_key" class="form-label">Mailchimp List ID</label>
                  <input type="text" name="setting[_mailchimp_list_id]" value="{{ (isset($settings['_mailchimp_list_id']['meta_val']))? $settings['_mailchimp_list_id']['meta_val']:'' }}" class="form-control" id="mailchimp_api_key">
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
