@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Search</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Search</li>
                <li class="breadcrumb-item active">list</li>
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
                            <div class="col-lg-12">
                                Search results for all modules
                            </div>
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Results</label><br>
                                {{-- @if ($searchResults['App\Models\JobCategory'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Job Category: Total ({{ $searchResults['App\Models\JobCategory']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\JobCategory'] as $jobCategory)
                                            <div class="col-md-6">
                                                <a href="{{ route('job_categories.show', $jobCategory->id) }}">
                                                    <span class="fw-bold">{{ $jobCategory->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif --}}


                                @if ($searchResults['App\Models\User'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Users: Total ({{ $searchResults['App\Models\User']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\User'] as $user)
                                            <div class="col-md-6">
                                                <a href="{{ route('users.show', $user->id) }}">
                                                    <span class="fw-bold">{{ $user->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif

                                @if ($searchResults['App\Models\Application'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Applications: Total ({{ $searchResults['App\Models\Application']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\Application'] as $application)
                                            <div class="col-md-6">
                                                <a href="{{ route('applications.show', $application->id) }}">
                                                    <span class="fw-bold">{{ $application->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif


                                @if ($searchResults['App\Models\Blog'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Blogs: Total ({{ $searchResults['App\Models\Blog']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\Blog'] as $blog)
                                            <div class="col-md-6">
                                                <a href="{{ route('blog.show', $blog->id) }}">
                                                    <span class="fw-bold">{{ $blog->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif

                                {{-- @if ($searchResults['App\Models\BlogCategory'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Blog Categories: Total ({{ $searchResults['App\Models\BlogCategory']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\BlogCategory'] as $blogCategory)
                                            <div class="col-md-6">
                                                <a href="{{ route('blog_categories.show', $blogCategory->id) }}">
                                                    <span class="fw-bold">{{ $blogCategory->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif --}}

                                {{-- @if ($searchResults['App\Models\Category'])
                                    <div class="row">
                                        <h6 class="card-title">
                                            Categories: Total ({{ $searchResults['App\Models\Category']->count() }})
                                        </h6>
                                        @forelse ($searchResults['App\Models\Category'] as $category)
                                            <div class="col-md-6">
                                                <a href="{{ route('job_categories.show', $category->id) }}">
                                                    <span class="fw-bold">{{ $category->name }}</span>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
