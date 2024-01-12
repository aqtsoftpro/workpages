@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Site Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Site Settings</li>
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
                    <input type="hidden" name="setting_form_type" value="general_settings" >
                    <div class="col-md-12">
                      <label for="_site_name" class="form-label">Site Name</label>
                      <input type="text" name="setting[_site_name]" value="{{ (isset($settings['_site_name']['meta_val']))? $settings['_site_name']['meta_val']:'' }}" class="form-control" id="_site_name">
                    </div>
                    <div class="col-md-12">
                      <label for="_admin_email" class="form-label">Admin Email</label>
                      <input type="email" name="setting[_admin_email]" value="{{ (isset($settings['_admin_email']['meta_val']))? $settings['_admin_email']['meta_val']:'' }}" class="form-control" id="_admin_email">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_email" class="form-label">Site Email</label>
                      <input type="email" name="setting[_site_email]" value="{{ (isset($settings['_site_email']['meta_val']))? $settings['_site_email']['meta_val']:'' }}" class="form-control" id="_site_email">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_contact_no" class="form-label">Contact No</label>
                      <input type="text" name="setting[_site_contact_no]" value="{{ (isset($settings['_site_contact_no']['meta_val']))? $settings['_site_contact_no']['meta_val']:'' }}" class="form-control" maxlength="15" id="_site_contact_no">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_support_no" class="form-label">Support No</label>
                      <input type="text" name="setting[_site_support_no]" value="{{ (isset($settings['_site_support_no']['meta_val']))? $settings['_site_support_no']['meta_val']:'' }}" class="form-control" maxlength="15" id="_site_support_no">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_city" class="form-label">City</label>
                      <input type="text" name="setting[_site_city]" value="{{ (isset($settings['_site_city']['meta_val']))? $settings['_site_city']['meta_val']:'' }}" class="form-control" id="_site_city">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_country" class="form-label">Country</label>
                      <input type="text" name="setting[_site_country]" value="{{ (isset($settings['_site_country']['meta_val']))? $settings['_site_country']['meta_val']:'' }}" class="form-control" id="_site_country">
                    </div>
                    <div class="col-md-12">
                      <label for="_site_address" class="form-label">Address</label>
                      <input type="text" name="setting[_site_address]" value="{{ (isset($settings['_site_address']['meta_val']))? $settings['_site_address']['meta_val']:'' }}" class="form-control" id="_site_address">
                    </div>
                    {{-- <div class="col-md-12">
                      <label for="site_language_id" class="form-label">Language</label>
                      <select class="form-select" name="setting[_site_language_id]"  id="site_language_id">
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}"  {{ ($language->id == $settings['_site_language_id']['meta_val']) ? 'selected' : '' }} >{{ $language->name }}</option>
                        @endforeach
                      </select>
                    </div> --}}
                    {{-- <div class="col-md-12">
                      <label for="site_timezone" class="form-label">Timzone</label>
                      <select class="form-select" name="setting[_site_timezone]" id="site_timezone">
                        @foreach($timezones as $timezone)
                        <option value="{{ $timezone->id }}"  {{ ($timezone->id == $settings['_site_timezone']['meta_val']) ? 'selected' : '' }} >{{ $timezone->name }}</option>
                        @endforeach
                      </select>
                    </div> --}}
                    {{-- <div class="col-12">
                        <label for="emailTemplate" class="form-label">Email Template</label>
                        <textarea class="form-control" name="email_template">{{ $settings->email_template }}</textarea>
                    </div>
                    <div class="col-12">
                        <label for="smsTemplate" class="form-label">SMS Template</label>
                        <textarea class="form-control" name="sms_template">{{ $settings->sms_template }}</textarea>
                    </div>
                    <div class="col-6">
                        <label for="inputAddress5" class="form-label">Notification</label>
                        <select class="form-select" name="notification">
                          @foreach($notification as $option)
                          <option value="{{ $option['id'] }}"  {{ ($option['id'] == $settings->notification) ? 'selected' : '' }} >{{ $option['name'] }}</option>
                          @endforeach
                        </select>
                      </div> --}}
                      <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                      </div>
                  </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  
<script>
    $(document).ready(function() {
      // Function to format Australian phone number
      function formatPhoneNumber(input) {
        // Remove non-numeric characters
        var phoneNumber = input.replace(/\D/g, '');

        // Apply the custom Australian phone number format
        var formattedPhoneNumber = phoneNumber.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '$1-$2-$3 $4');

        return formattedPhoneNumber;
      }

      // Event handler for input changes
      $('#_site_contact_no').on('input', function() {
        // Get the current value of the input
        var inputValue = $(this).val();

        // Format the phone number
        var formattedValue = formatPhoneNumber(inputValue);

        // Update the input value with the formatted phone number
        $(this).val(formattedValue);
      });

      $('#_site_support_no').on('input', function() {
        // Get the current value of the input
        var inputValue = $(this).val();

        // Format the phone number
        var formattedValue = formatPhoneNumber(inputValue);

        // Update the input value with the formatted phone number
        $(this).val(formattedValue);
      });
    });
</script>

@endsection
