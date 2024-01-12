<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategoryRelation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(){

        $records = Blog::orderBy('name', 'ASC')->get();
        $blog_cats = BlogCategory::orderBy('name', 'ASC')->get();
        return view('admin.blog.index', compact('records', 'blog_cats'));
    }

    public function create()
    {
        $blog_cats = BlogCategory::orderBy('name', 'ASC')->get();

        return view('admin.blog.create', compact( 'blog_cats'));
    }

    public function store(Request $request)
    {

        $post        = new Blog();
        $post->name  = $request->name;
        $post->slug  = Str::slug($request->name);
        $post->desc  = addslashes($request->desc);
        $post->save();

        if($request->file('blog_img_select'))
            {
                $blog_img_select = time().'-'.rand(100000,1000000).'.'.$request->file('blog_img_select')->extension();
                $request->file('blog_img_select')->move(public_path('uploads'), $blog_img_select);

                $data =  array(
                    'photo' => $blog_img_select,
                );

                Blog::where('id', $post->id)->update($data);
            }


        if($request->blog_cat)
        {
          foreach($request->blog_cat as $cat)
            {

                $post_cat_relation        = new BlogCategoryRelation();
                $post_cat_relation->post_id  = $post->id;
                $post_cat_relation->category_id  = $cat;
                $post_cat_relation->save();
            }  
        }

   
        if($post)
        {
            return redirect()->route('blog.index')
                        ->with('success',''.$request->name.' blog added successfully.');
        }
        else
        {
            return redirect()->route('blog.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = Blog::find($id);
        $blog_cats = BlogCategory::orderBy('name', 'ASC')->get();

        $blog_category_relation = BlogCategoryRelation::select('category_id')->where('post_id', $id)->get()->keyBy('category_id')->toArray();

        return view('admin.blog.edit', compact('record', 'blog_cats', 'blog_category_relation'));
    }

    public function update(Request $request, string $id)
    {
        print_r($request->all());
        $data =  array(
            'name' => $request->name,
            'desc' => addslashes($request->desc),
        );
       
        $affectedRows = Blog::where('id', $id)->update($data);
        
        DB::delete('delete from blog_categries_relation where post_id = ?',[$id]);
        if($request->blog_cat)
        {
          foreach($request->blog_cat as $cat)
            {

                $post_cat_relation        = new BlogCategoryRelation();
                $post_cat_relation->post_id  = $id;
                $post_cat_relation->category_id  = $cat;
                $post_cat_relation->save();
            }  
        }

        if($request->file('blog_img_select'))
        {
            $blog_img_select = time().'-'.rand(100000,1000000).'.'.$request->file('blog_img_select')->extension();
            $request->file('blog_img_select')->move(public_path('uploads'), $blog_img_select);

            $data =  array(
                'photo' => $blog_img_select,
            );

            Blog::where('id', $id)->update($data);
        }
 
        if($affectedRows)
            {
                return redirect()->back()->with('success', ''.$request->name.' blog updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    
    }

    public function destroy(string $id)
    {
        $deleted_rec = Blog::find($id);

        if(Blog::destroy($id)) {

            return redirect()->route('blog.index')
                        ->with('success',''.$deleted_rec->name.' blog deleted successfully');
          } else {
            return redirect()->route('blog.index')
                        ->with('error','Please try again!');
        }
    }

    public function categories(){
        return view('admin.blog.categories');
    }


    
}
