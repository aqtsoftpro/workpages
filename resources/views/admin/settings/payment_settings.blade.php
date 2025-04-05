@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Payment Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Payment Settings</li>
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


        <form class="row g-3" action="{{ url('admin/settings/update_main_settings/')  }}" method="POST">
            @csrf
            <input type="hidden" name="setting_form_type" value="payment_gateway_settings" >

      <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Payment Mode</h5>

                    <!-- Default Tabs -->
                    <div class="col-md-12">

                    <div class="form-check form-switch">
                        <input class="form-check-input payment_method" type="checkbox" name="setting[_payment_method_direct_deposite]" id="payment_method_direct_deposite_checkbox" {{ (isset($settings['_payment_method_direct_deposite']['meta_val']) && $settings['_payment_method_direct_deposite']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                        <label class="form-check-label" for="payment_method_direct_deposite_checkbox">Direct Deposit</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input payment_method" type="checkbox" name="setting[_payment_method_credit_card]" id="payment_method_credit_card_checkbox" {{ (isset($settings['_payment_method_credit_card']['meta_val']) && $settings['_payment_method_credit_card']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                        <label class="form-check-label" for="payment_method_direct_deposite_checkbox">Credit Card</label>
                    </div>

                    </div>

            </div>
        </div>
      </div>

      <div class="col-lg-12" id="payment_method_direct_deposite" style="display:{{ (isset($settings['_payment_method_direct_deposite']['meta_val']) && $settings['_payment_method_direct_deposite']['meta_val'] ==  '1')? 'block':'none' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Direct Deposit ( Custom Message )</h5>

                    <div class="col-md-12">
                        <label for="direc_deposite_custom_message" class="form-label">Custom Message</label>


                        <textarea name="setting[_direc_deposite_custom_message]" class="tinymce-editor">{{ stripslashes((isset($settings['_direc_deposite_custom_message']['meta_val']))? $settings['_direc_deposite_custom_message']['meta_val']:'') }}</textarea>
                    </div>

                <div class="col-md-12 mt-4">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>


          </div>
        </div>
      </div>

      <div class="col-lg-12"  id="payment_method_credit_card" style="display:{{ (isset($settings['_payment_method_credit_card']['meta_val']) && $settings['_payment_method_credit_card']['meta_val'] ==  '1')? 'block':'none' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Stripe Settings</h5>


                <!-- Default Tabs -->
                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="setting[_strip_status]" id="flexSwitchCheckChecked" {{ (isset($settings['_strip_status']['meta_val']) && $settings['_strip_status']['meta_val'] ==  '1')? 'checked':'' }} value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Test Mode</label>
                  </div>
                  <hr>

                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="live-tab" data-bs-toggle="tab" data-bs-target="#live" type="button" role="tab" aria-controls="live" aria-selected="true">Live</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="test-tab" data-bs-toggle="tab" data-bs-target="#test" type="button" role="tab" aria-controls="test" aria-selected="false" tabindex="-1">Test</button>
                  </li>
                </ul>
                <div class="tab-content pt-2" id="myTabContent">
                  <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="live-tab">

                    <div class="col-md-12">
                      <label for="stripe_live_publishable_key" class="form-label">Live Publishable Key</label>
                      <input type="text" name="setting[_stripe_live_publishable_key]" value="{{ (isset($settings['stripe_live_publishable_key']['meta_val']))? $settings['stripe_live_publishable_key']['meta_val']:'' }}" class="form-control" id="stripe_live_publishable_key">
                    </div>
                    <div class="col-md-12">
                      <label for="stripe_live_secret_key" class="form-label">Live Secret Key</label>
                      <input type="text" name="setting[_stripe_live_secret_key]" value="{{ (isset($settings['stripe_live_secret_key']['meta_val']))? $settings['stripe_live_secret_key']['meta_val']:'' }}" class="form-control" id="stripe_live_secret_key">
                    </div>

                  </div>
                  <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">

                    <div class="col-md-12">
                      <label for="test_publishable_key" class="form-label">Test Publishable Key</label>
                      <input type="text" name="setting[_test_publishable_key]" value="{{ (isset($settings['_test_publishable_key']['meta_val']))? $settings['_test_publishable_key']['meta_val']:'' }}" class="form-control" id="live_publishable_key">
                    </div>
                    <div class="col-md-12">
                      <label for="test_secret_key" class="form-label">Test Secret Key</label>
                      <input type="text" name="setting[_test_secret_key]" value="{{ (isset($settings['_test_secret_key']['meta_val']))? $settings['_test_secret_key']['meta_val']:'' }}" class="form-control" id="test_secret_key">
                    </div>

                  </div>
                </div><!-- End Default Tabs -->


                <div class="col-md-12 mt-4">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>



          </div>
        </div>
      </div>

        </form>

    </div>
  </section>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const directDepositCheckbox = document.getElementById("payment_method_direct_deposite_checkbox");
        const creditCardCheckbox = document.getElementById("payment_method_credit_card_checkbox");
        const directDepositDiv = document.getElementById("payment_method_direct_deposite");
        const creditCardDiv = document.getElementById("payment_method_credit_card");

        function togglePaymentMethods() {
            if (directDepositCheckbox.checked) {
                directDepositDiv.style.display = "block";
                creditCardDiv.style.display = "none";
                creditCardCheckbox.checked = false;
            } else if (creditCardCheckbox.checked) {
                creditCardDiv.style.display = "block";
                directDepositDiv.style.display = "none";
                directDepositCheckbox.checked = false;
            } else {
                // Default state when neither is checked
                directDepositDiv.style.display = "none";
                creditCardDiv.style.display = "none";
            }
        }

        // Add event listeners
        directDepositCheckbox.addEventListener("change", function() {
            if (this.checked) {
                creditCardCheckbox.checked = false;
            }
            else
            {
                creditCardCheckbox.checked = true;
            }
            togglePaymentMethods();
        });

        creditCardCheckbox.addEventListener("change", function() {
            if (this.checked) {
                directDepositCheckbox.checked = false;
            }
            else
            {
                directDepositCheckbox.checked = true;
            }
            togglePaymentMethods();
        });

        // Set initial state
        togglePaymentMethods();
    });
    </script>


@endsection
