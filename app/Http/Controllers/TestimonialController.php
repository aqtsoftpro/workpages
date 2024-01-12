<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Testimonial;
use Illuminate\Http\Request;


class TestimonialController extends Controller
{

    public function index()
    {
        $records = Testimonial::orderBy('name', 'ASC')->get();
        return view('admin.testimonials.index', compact('records'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {

        $added_rec = Testimonial::create($request->all());

        if($request->file('image'))
        {
            echo $FileName = time().'-'.rand(100000,1000000).'.'.$request->file('image')->extension();
            $request->file('image')->storeAs('public', $FileName);
            
            if(isset($FileName)){
                $image = env('APP_URL') . '/storage/' . $FileName;
            }
            
            Testimonial::where("id", $added_rec->id)->update(["image" => $image]);
        }

        

        if($added_rec)
        {
            return redirect()->route('testimonials.index')
                        ->with('success','Testimonial added successfully!');
                        
        }
        else
        {
            return redirect()->route('testimonials.index')
                        ->with('success','Something went wrong. Please try again.');
        }
    }

    public function edit(string $id)
    {
        $record = Testimonial::find($id);

        return view('admin.testimonials.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::find($id);

        $updated_rec = $testimonial->update($request->all());


        if($request->file('image'))
        {
            $FileName = time().'-'.rand(100000,1000000).'.'.$request->file('image')->extension();
            $request->file('image')->storeAs('public', $FileName);
            
            if(isset($FileName)){
                $image = env('APP_URL') . '/storage/' . $FileName;
            }
            
            Testimonial::where("id", $id)->update(["image" => $image]);
        }
        

        if($updated_rec)
            {
                return redirect()->back()->with('success', ''.$request->name.' testimonail updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }
    
        }

    public function destroy(string $id)
    {
        $deleted_rec = Testimonial::find($id);

        if(Testimonial::destroy($id)) {

            return redirect()->route('testimonials.index')
                        ->with('success',''.$deleted_rec->name.' testimonial deleted successfully');
          } else {
            return redirect()->route('testimonials.index')
                        ->with('error','Please try again!');
        }
    }

    public function testimonials(Testimonial $Testimonial)
    {
        $testimonials = Testimonial::get()->toArray();
        return response()->json($testimonials);
    }
}
