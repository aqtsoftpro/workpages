@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Blog</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Blog</li>
      <li class="breadcrumb-item active">{{ $record->name }}</li>
    </ol>
  </nav>
</div>

@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif(Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<form method="POST"  action="{{ route('blog.update',$record->id) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title row">
              <div class="col-lg-6">
                Edit {{ $record->name }}
              </div>
              <div class="col-lg-6">
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                  <a href="{{ url('admin/blog') }}" class="btn btn-success">View all</a>
                  <a href="{{ url('admin/blog/create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
            </h5>
            
            
                <div class="row g-3">
                  
                  
                    <div class="col-md-12">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="{{ $record->name }}" class="form-control" id="name">
                    </div>
                    <div class="col-md-12">
                      <label for="slug" class="form-label">Slug</label>
                      <input type="text" name="slug" value="{{ $record->slug }}" class="form-control" id="slug" disabled readonly>
                    </div>
                    <div class="col-md-12">
                      <!-- TinyMCE Editor -->
                      <textarea name="desc" class="tinymce-editor">{{ stripslashes($record->desc) }}</textarea>
                      <!-- End TinyMCE Editor -->
                    </div>
  
                    <div>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    
                  </div>
          </div>
        </div>

      </div>

      <div class="col-lg-4">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title row">
                  <div class="col-lg-12">
                    Categories
                  </div>
                </h5>
                <ul class="list-group">
  
                  @foreach ($blog_cats as $blog_cat)
                    <li class="list-group-item"><input type="checkbox" name="blog_cat[]" {{ isset($blog_category_relation[$blog_cat->id])?'checked':'' }} value="{{ $blog_cat->id }}"> <small>{{ $blog_cat->name }}</small></li>
                  @endforeach

                </ul>
                
                    
              </div>
            </div>
    
          </div>

          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title row">
                  <div class="col-lg-12">
                    Featured Image
                  </div>
                </h5>
                
                <div class="col-lg-12" id="blog-img-container">
                  @if ($record->photo)
                  @php
                      $blog_img  = URL::to('/uploads').'/'.$record->photo;
                  @endphp
                    <img id="blog_img" src="{{ $blog_img }}"  />
                  @else
                    <img id="blog_img" src="#" style="display: none" />
                  @endif
                  
                </div>
                <br>
                <input type="file" name="blog_img_select" value="" class="form-control" id="blog_img_select">
                    
              </div>
            </div>
    
          </div>

        </div>
      </div>

      


    </div>
  </section>
</form>  

<script type="">
  $(document).ready(function() 
  {
    function readURL(input)
    {
      if (input.files && input.files[0]) {

          var reader = new FileReader();

          reader.onload = function (e) {
              $('#blog_img').attr('src', e.target.result);
              $('#blog_img').show();
          }
          reader.readAsDataURL(input.files[0]);

      }
    }

  $("#blog_img_select").change(function(){
      readURL(this);
  });

  });
</script>

@endsection
