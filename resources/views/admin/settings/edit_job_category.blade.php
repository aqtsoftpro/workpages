@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Job Categories</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Job Category</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Job Category</h5>
            <form method="POST" action={{ url('/admin/settings/edit_job_category' . '/' . $job_category->id) }}>
                @csrf
                <div class="col-md-6">
                    <label for="inputName5" class="form-label" >Job Category</label>
                    <input value="{{ $job_category->name }}" type="text" name="name" class="form-control" >
                </div>
                <div class="col-md-6 mt-2">
                    <button class="btn btn-primary">Update Job Category</button>
                </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
