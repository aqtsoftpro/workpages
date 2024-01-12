<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms;
use Stringable;
use Illuminate\Support\Str;

class AdminCmsController extends Controller
{
    public function index(){

        $records = Cms::orderBy('name', 'ASC')->get();
        return view('admin.cms.index', compact('records'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        echo $request->name;

        $post        = new Cms();
        $post->name  = $request->name;
        $post->slug  = Str::slug($request->name);
        $post->desc  = addslashes($request->desc);
        $post->save();

        if($post)
        {
            return redirect()->route('manage_pages.index')
                        ->with('success',''.$request->name.' page added successfully.');
        }
        else
        {
            return redirect()->route('manage_pages.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }


    public function edit(string $id)
    {
        $record = Cms::find($id);

        return view('admin.cms.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
 

        $data =  array(
            'name' => $request->name,
            'desc' => addslashes($request->desc),
        );
        print_r($data);
        $affectedRows = Cms::where('id', $id)->update($data);

        if($affectedRows)
            {
                return redirect()->back()->with('success', ''.$request->name.' page updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    
    }



    public function destroy(string $id)
    {
        $deleted_rec = Cms::find($id);

        if(Cms::destroy($id)) {

            return redirect()->route('manage_pages.index')
                        ->with('success',''.$deleted_rec->name.' page deleted successfully');
          } else {
            return redirect()->route('manage_pages.index')
                        ->with('error','Please try again!');
        }
    }


    public function get_page(Request $request)
    {

        $page_content = Cms::where('slug', $request->page_slug)->first();

        return response()->json($page_content->desc);
    }

}
