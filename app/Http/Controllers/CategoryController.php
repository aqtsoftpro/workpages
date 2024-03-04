<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Stringable;

class CategoryController extends Controller
{

    public function index() : View
    {
        $records = Category::orderBy('name', 'ASC')->get();
        return view('admin.job_categories.index', compact('records'));
    }

    public function create(): View
    {
        return view('admin.job_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {


        $added_rec = Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'slug' =>  Str::slug($request->name),
        ]);


        if($request->file('image'))
        {
            $FileName = 'cat-'.time().'-'.rand(100000,1000000).'.'.$request->file('image')->extension();
            $request->file('image')->storeAs('public', $FileName);
            
            if(isset($FileName)){
                $image = env('APP_URL') . '/storage/' . $FileName;
            }
            
            Category::where("id", $added_rec->id)->update(["image" => $image]);
        }

        if($added_rec)
        {
            return redirect()->route('job_categories.index')
                        ->with('success',''.$request->name.' Job category added successfully.');
        }
        else
        {
            return redirect()->route('job_categories.index')
                        ->with('success','Something went wrong. Please try again.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record = Category::find($id);
        

        return view('admin.job_categories.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Category $category, string $id)
    // {
    //     print_r($request->all());
    //     if($category->update($request->all())){
    //         // return redirect()->back()->with('success', 'Settings updated successfully');
    //         echo "okok";

    //     } else {
    //         // //return new \Illuminate\Database\QueryException();
    //         // //return redirect()->back()->with('error', new \Exception('Something went wrong'));
    //         // return redirect()->back()->with('error', 'Something went wrong');
    //     }
    // }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = Category::find($id);

        $updated_rec = $category->update($request->all());

        if($request->file('image'))
        {
            $FileName = 'cat-'.time().'-'.rand(100000,1000000).'.'.$request->file('image')->extension();
            $request->file('image')->storeAs('public', $FileName);

            $imagePath = $request->file('image')->store('categories','public');
            // Add the image path to the form data before saving to the database 
            
            // dd($imagePath);
            
            if(isset($imagePath)){
                $image = env('APP_URL') .'storage/'.$imagePath;
                // dd($image);
            }
            Category::where("id", $id)->update(["image" => $image]);
        }
  
        if($updated_rec)
            {
                return redirect()->back()->with('success', ''.$request->name.' category updated successfully');
            }
            else
            {
                return redirect()->back()->with('success', 'Something went wrong. Please try again!');
            }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted_rec = Category::find($id);

        if(Category::destroy($id)) {

            return redirect()->route('job_categories.index')
                        ->with('success',''.$deleted_rec->name.' category deleted successfully');
          } else {
            return redirect()->route('job_categories.index')
                        ->with('error','Please try again!');
        }
    }

    public function categories(Category $category){

        // $categories = Category::select('job_categories.*', 'stats.counts as cat_counts')
        // ->where('stats.counts', '!=', '')
        // ->leftJoin('stats', 'job_categories.id', '=', 'stats.ref_id')
        // ->orderBy('job_categories.name', 'ASC')
        // ->get();
        $categories = Category::with('stats')->get();
        return response()->json($categories);
    }

    public function trending_jobs_categories(Category $category){

        // $trending_jobs_categories = Category::select('job_categories.*', 'stats.counts as cat_counts')
        // ->leftJoin('stats', 'job_categories.id', '=', 'stats.ref_id')
        // ->orderBy('stats.counts', 'DESC')
        // ->get();

        // $trending_jobs_categories = Category::select('job_categories.*')
        // ->from('job_categories')
        // ->leftJoin('jobs', 'job_categories.id', '=', 'jobs.category_id')
        // // ->orderBy('cat_counts', 'DESC')
        // // ->groupBy('job_categories.id')
        // ->get();

        // $trending_jobs_categories = DB::table('job_categories')
        // ->select('job_categories.*', 'jobs.*')
        // ->leftJoin('jobs', 'job_categories.id', '=', 'jobs.category_id')
        // ->get();

        // $trending_jobs_categories = DB::table('job_categories')
        // ->leftJoin('jobs', 'job_categories.id', '=', 'jobs.id')
        // ->select('job_categories.id','job_categories.name' , DB::raw('COUNT(jobs.id) as item_count'))
        // ->groupBy('job_categories.id')
        // ->get();

        $jobs_categories = DB::table('job_categories')
        ->Join('jobs', 'job_categories.id', '=', 'jobs.category_id')
        ->select( 'jobs.category_id', DB::raw('COUNT(jobs.id) as cat_counts'))
        ->groupBy('jobs.category_id')
        ->orderBy('cat_counts', 'DESC')
        ->limit(12)
        ->get();

        $trending_jobs_categories = array();
        $i = 0;
        foreach($jobs_categories as $cat)
        {
            // print_r($cat);
            $getCat = Category::where('id', $cat->category_id)->first()->toArray();
            // print_r($getCat);
            $trending_jobs_categories[$i]['id'] = $cat->category_id;
            $trending_jobs_categories[$i]['name'] = $getCat['name'];
            $trending_jobs_categories[$i]['slug'] = $getCat['slug'];
            $trending_jobs_categories[$i]['image'] = $getCat['image'];
            $trending_jobs_categories[$i]['cat_counts'] = $cat->cat_counts;
            $i++;
        }

        


//         SELECT
// 	job_categories.*, COUNT(jobs.id) AS job_counts
// FROM
// 		job_categories
// 	INNER JOIN
// 		jobs
// 	ON 
// 		job_categories.id = jobs.category_id
// 	GROUP BY job_categories.id;

        return response()->json($trending_jobs_categories);
    }
}
