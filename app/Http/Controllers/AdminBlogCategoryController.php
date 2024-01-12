<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class AdminBlogCategoryController extends Controller
{
    public function index(){
        $records = BlogCategory::orderBy('name', 'ASC')->get();
        return view('admin.blog_categories.index', compact('records'));
    }

    public function create()
    {
        return view('admin.blog_categories.create');
    }

    public function store(Request $request)
    {

        $post        = new BlogCategory();
        $post->name  = $request->name;
        $post->slug  = Str::slug($request->name);
        $post->save();

        if($post)
        {
            return redirect()->route('blog_categories.index')
                        ->with('success',''.$request->name.' blog categogry added successfully.');
        }
        else
        {
            return redirect()->route('blog_categories.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }



    public function edit(string $id)
    {
        $record = BlogCategory::find($id);

        return view('admin.blog_categories.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {

        $data =  array(
            'name' => $request->name,
        );
  
        $affectedRows = BlogCategory::where('id', $id)->update($data);

        if($affectedRows)
            {
                return redirect()->back()->with('success', ''.$request->name.' blog category updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    
    }

    public function show(string $id)
    {
        // return view('admin.locations.create');
    }

    public function destroy(string $id)
    {
        $deleted_rec = BlogCategory::find($id);

        if(BlogCategory::destroy($id)) {

            return redirect()->route('blog_categories.index')
                        ->with('success',''.$deleted_rec->name.' blog category deleted successfully');
          } else {
            return redirect()->route('blog_categories.index')
                        ->with('error','Please try again!');
        }
    }


    
}
