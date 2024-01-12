@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Email Template</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Email Template</li>
      <li class="breadcrumb-item active">Create Template</li>
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
                Create Email Template
              </div>
              <div class="col-lg-6">

              </div>
            </h5>

                <form method="POST"  action="{{ route('email_templates.store') }}" class="row g-3" >

                  @csrf

                    <div class="col-md-12">
                      <label for="email_template" class="form-label">Name</label>
                      <input type="text" name="name" value="" class="form-control" placeholder="enter template name" id="email_template" >
                    </div>
                    <div class="col-md-12">
                        <label for="email_template" class="form-label">Slug</label>
                        <input type="text" name="slug" value="" class="form-control" placeholder="slug" id="slug" >
                      </div>
                    <div class="col-md-12">
                        <label for="name" class="form-label">Template Type </label><br>
                        <select name="email_type" class="form-control">
                            <option>admin</option>
                            <option>company</option>
                            <option>job seeker</option>
                        </select>
                      </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Tags </label><br>
                      <input type="text" name="tags"  class="form-control" placeholder="add tags separated by comma e.g. tag1, tag2" id="tags" >
                    </div>
                    <input type="hidden" name="desc" value="" />
                    {{--  <div class="col-md-12">
                      <label for="name" class="form-label">Template Content</label>
                      <textarea class="form-control" id="email-content-area" name="desc" style="height: 200px"></textarea>
                    </div>  --}}


                    <div>
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </form>
                
          </div>
        </div>

      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      // Click event for adding tag to textarea
      $(document).on('click', '.tag', function() {
        var tagText = $(this).text();
        $('#email-content-area').val($('#email-content-area').val() + tagText + ' ');
      });

      // Click event for deleting tag
      $(document).on('click', '.tag-delete', function() {
        $(this).parent().remove();
      });

      // Example: Add tags dynamically
      function addTag(tagText) {
        var $tag = $('<div class="tag">' + tagText + '<span class="tag-delete">X</span></div>');
        $('#tags-container').append($tag);
      }

      // Adding some example tags
      addTag('Tag1');
      addTag('Tag2');
      addTag('Tag3');
    });
  </script>

@endsection
