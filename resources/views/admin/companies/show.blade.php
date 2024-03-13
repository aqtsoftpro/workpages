@extends('layouts.app')

@section('content')

{{ $record  }}
<div class="pagetitle">
  <h1>View Company</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">View Company</li>
      <li class="breadcrumb-item active">{{ $record->name }}</li>
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
            <h5 class="card-title row">
              <div class="col-lg-6">
                View {{ $record->name }}
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/companies') }}" class="btn btn-success">View all</a>
                </div>
              </div>
            </h5>
            <div class="row">
              <div class="col-md-3">
                <b>Company Name</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->name }}
              </div>
              <div class="col-md-3">
                <b>Company Type</b>
              </div>
              <div class="col-md-3">
                {{ $record->company_type->name }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <b>Owner Name</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->owner->name }}
              </div>
              <div class="col-md-3">
                <b>Email</b>
              </div>
              <div class="col-md-3">
                {{ $record->owner->email }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <b>Location</b>
              </div>
              <div class="col-md-3 border-end">
                {{ (isset($record->location->name))?$record->location->name:'' }}
              </div>
              <div class="col-md-3">
                <b>Website Link</b>
              </div>
              <div class="col-md-3">
                {{ $record->weblink }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <b>Facebook</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->facebook }}
              </div>
              <div class="col-md-3">
                <b>Twitter</b>
              </div>
              <div class="col-md-3">
                {{ $record->twitter }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <b>LinkedIn</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->linkedin }}
              </div>
              <div class="col-md-3">
                <b>Pinterest</b>
              </div>
              <div class="col-md-3">
                {{ $record->pinterest }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <b>Dribbble</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->dribbble }}
              </div>
              <div class="col-md-3">
                <b>Behance</b>
              </div>
              <div class="col-md-3">
                {{ $record->behance }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <b>Logo</b>
              </div>
              <div class="col-md-4 border-end">
                <img src="{{ ($record->logo)?$record->logo:'' }}" width="100" />
              </div>
              <div class="col-md-2">
                <b>Cover</b>
              </div>
              <div class="col-md-4">
                <img src="{{ ($record->cover_photo)?$record->cover_photo:'' }}" width="250" />
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>  

            <div class="row">
              <div class="col-md-3">
                <b>Total Jobs</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->jobs_count }}
              </div>
              <div class="col-md-3">
                <b>Total Applications</b>
              </div>
              <div class="col-md-3">
                {{ $record->applications_count }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b>Total Subscriptions</b>
              </div>
              <div class="col-md-3 border-end">
                {{ $record->owner->subscriptions->count() }}
              </div>
              <div class="col-md-3">
                <b>Latest Subscription</b>
              </div>
              <div class="col-md-3">
                {{ $record->owner->subscriptions }}
              </div>
              <div class="col-md-12">
                <hr>
              </div>
            </div>
        
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
