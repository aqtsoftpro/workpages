<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Application, BookmarkJob, CompanyReview, Rating, Designation, JobSeeker, Package, JobCategory, Blog, BlogCategory, Category, Company, User, Permission};


class AdminSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * get data that matches with table
     */
    public function search(Request $request)
    {

       $searchResults = [];
        $searchModels = [
            Application::class,
            Blog::class,
            // BlogCategory::class,
            // BookmarkJob::class,
            // Category::class,
            Company::class,
            CompanyReview::class,
            // Designation::class,
            // JobCategory::class,
            JobSeeker::class,
            // Package::class,
            // Portfolio::class,
            // Qualification::class,
            // Rating::class,
            User::class,
        ];

        foreach ($searchModels as $model) {
            $searchResults[basename($model)] = $model::search($request->keyword)->get();
        }

        return view('admin.search.index', compact('searchResults'));
    //    dd($jobCategories, $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SearchableModule $searchableModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SearchableModule $searchableModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SearchableModule $searchableModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SearchableModule $searchableModule)
    {
        //
    }
}
