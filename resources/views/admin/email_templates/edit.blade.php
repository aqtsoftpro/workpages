@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Email Template</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Email Template</li>
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
                Edit {{ $record->name }}
              </div>
              <div class="col-lg-6">
          
              </div>
            </h5>
            
            
                <form method="POST"  action="{{ route('email_templates.update',$record->id) }}" class="row g-3" >
                  
                  @csrf
                  @method('PUT')
                
                    <div class="col-md-12">
                      <label for="email_template" class="form-label">Template Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="email_template" disabled  readonly>
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Click  on tag to add in email content box </label><br>
                      @php
                        $record->tags;
                        if($record->tags)
                          {
                            $tags = explode(",",$record->tags);
                            

                            foreach($tags as $tag)
                            { 
                              if (strpos($tag, '-') !== false) 
                              {
                                $option = explode("-",$tag);
                                $optional = "(".$option[1].")";
                                $tag = $option[0];

                              } else {
                                $optional = '';
                              }
                              @endphp
                              <span class="badge bg-info text-dark tag">[{{trim($tag)}}]</span>  <small>{{$optional}}</small>
                              @php      }

                          }
                      @endphp
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Template Content</label>
                      <textarea class="form-control" id="email-content-area" name="desc" style="height: 200px">{{ $record->desc }}</textarea>
                    </div>
                    
  
                    <div>
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
