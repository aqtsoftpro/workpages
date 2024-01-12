@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Locations</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Locations</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Location</h5>
            <form method="POST" action={{ url('/admin/settings/edit_location' . '/' . $location->id) }}>
                @csrf
                <div class="col-md-6">
                    <label for="inputName5" class="form-label" >Name</label>
                    <input value="{{ $location  ->name }}" type="text" name="name" class="form-control" >
                </div>
                <div class="col-md-6 mt-2">
                    <button class="btn btn-primary">Update Location</button>
                </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
