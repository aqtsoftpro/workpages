<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category){

        $records = Category::get();
        return view('admin.job_categories.index', compact('records'));
        
    }

    // public function index(Category $category){

        
    //     return response()->json($category->all());
    // }

    public function show(Category $category){
        return response()->json($category);
    }

    public function store(Request $request, Category $category){
        try{
            $newCategory = $category->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully!',
                'category' => $newCategory
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function edit(Category $category)
    {
        $record = $category;
        return view('admin.job_categories.edit', compact('record'));
    }

    public function update(Request $request, Category $category){
        try{
            $category->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully!',
                'category' => $category
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy($id,Category $category)
    {

        if(Category::destroy($id)) {

            return redirect()->route('job_categories.index')
                        ->with('success','Category deleted successfully');
          } else {
            return redirect()->route('job_categories.index')
                        ->with('error','Please try again!');
        }
        
    }

    // public function destroy(Category $category){
    //     $category->delete();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Category Deleted Successfully!'
    //     ]);
    // }
}
