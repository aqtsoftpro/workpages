@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Skills</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Skills</li>
      </ol>
    </nav>
  </div>

  @if(session()->has('success'))
  <div class="alert alert-success">{{ session()->get('success') }}</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger">{{ session()->get('error') }}</div>
@endif


  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Skills</h5>

            <form method="POST" action={{ url('/admin/settings/create_skill') }}>
                @csrf
                <div class="col-md-6">
                    <label for="inputName5" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <div class="col-md-6 mt-2">
                    <button class="btn btn-primary">Create Skill</button>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skills as $skill)
                        <tr>
                            <td>{{ $skill->name }}</td>
                            <td>
                                <a style="float:left" class="btn btn-primary" href="{{ url('/admin/settings/edit_skill' . '/' . $skill->id) }}">Edit</a>
                                <form style="float:left; margin-left: 10px" method="POST" action="{{url('/admin/settings/delete_skill' . '/' . $skill->id) }}">
                                    @csrf
                                    <input type="hidden" name="skill_id" value="{{ $skill->id }}" />
                                    <button class="btn btn-danger" type="submit" href="#">Delete</button>
                                </form>
                            </td>
                        <tr>
                    @endforeach
                </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
