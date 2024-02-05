<?php

namespace App\Http\Controllers;

use App\Models\{Portfolio, PortfolioImage};
use Exception;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Requests\PortfolioRequest;

class PortfolioController extends Controller
{

    public function updateUserPortfolio(Request $request, $id=null)
    {
        // dd($request->all());
        if ($id==null) {
            if ($request->hasFile('other_file')) {
                // Upload the image and store it in the default 'storage' disk
                $imagePath = $request->file('other_file')->store('portfolio/others', 'public');
                // Add the image path to the form data before saving to the database            
                // $inputs['other_file'] = $imagePath;
            }
    
            $portfolio = Portfolio::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'skill_used' => $request->skill_used,
                'other_file' => $imagePath ?? null,
                'video_links' => $request->video_links,
            ]);

            if ($portfolio) {
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        // Generate a unique name for each image
                        $newImage = $image->store('portfolio/images', 'public');
                        PortfolioImage::create([
                            'portfolio_id' => $portfolio->id,
                            'image' => env('FRONT_APP_URL') .'storage/'. $newImage,
                        ]);
                    }
                }
            }

            // if ($request->hasFile('images[0][file]')) {
            //     $image = $request->file('images[0][file]');
            //     dd($image);
            //     // Generate a unique name for the image
            //     $newImage = $image->store('portfolio/images', 'public');
            //     PortfolioImage::create([
            //         'portfolio_id' => $portfolio->id,
            //         'image' => $newImage,
            //     ]);
            // }
    

        } else {
            $portfolio = Portfolio::with('portfolioImages')->findOrFail($id);

            if ($request->hasFile('other_file')) {
                // Upload the image and store it in the default 'storage' disk
                $imagePath = $request->file('other_file')->store('portfolio/others', 'public');

            }
    
            $portfolio->update([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'skill_used' => $request->skill_used,
                'other_file' => $imagePath ?? null,
                'video_links' => $request->video_links,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique name for each image
                    $newImage = $image->store('portfolio/images', 'public');
                    PortfolioImage::create([
                        'portfolio_id' => $portfolio->id,
                        'image' => env('FRONT_APP_URL').'storage/'. $newImage,
                    ]);
                }
            }
        }
        
        // $inputs = $request->all();


        // else {
        //     Service::create($inputs);
        // }

        return response()->json(Portfolio::where('user_id', $request->user_id)->get()->toArray());

        // $portfolio[] = array(
        //         'title' => 'portfolio 11',
        //         'description' => 'description 1',
        //         'images' => array('image 1','image 1','image 1','image 1'),

        //     );
        // $portfolio[] = array(
        //         'title' => 'portfolio 12',
        //         'description' => 'description 1',
        //         'images' => array('image 1','image 1','image 1','image 1'),
        //     );
        // $portfolio[] = array(
        //     'title' => 'portfolio 13',
        //     'description' => 'description 1',
        //     'images' => array('image 1','image 1','image 1','image 1'),
        // );
        // print_r($portfolio);
        
        // echo json_encode($portfolio);

        // $portfolios = $request->all();
        // print_r($portfolios['portfolio']);

        // foreach($portfolios['portfolio']['name'] as $name_key => $name)
        // {
        //     if($name_key == 0)
        //     {
        //         continue;
        //     }
            
        //     if(isset($portfolios['portfolio']['portfolioID'][$name_key]) && $portfolios['portfolio']['portfolioID'][$name_key] != '')
        //         {
        //             // echo $name;
        //             echo $portfolios['portfolio']['portfolioID'][$name_key];
        //             Portfolio::where('id', $portfolios['portfolio']['portfolioID'][$name_key])
        //             ->update([
        //                 'name' => $name,
        //                 'description' => $portfolios['portfolio']['description'][$name_key],
        //                 // 'images' => json_encode($portfolio['images']),
        //             ]);
        //         }
        //         else
        //         {
        //             echo $name;
        //             Portfolio::create([
        //                 'user_id' => $id,
        //                 'name' => $name,
        //                 'description' => $portfolios['portfolio']['description'][$name_key],
        //                 // 'images' => json_encode($portfolio['images']),
        //             ]);
        //         };
        //     // echo "<pre>";    
        //     // print_r($portfolio);
        //     // echo "<pre>"; 
        // }
    }

    public function getUserPortfolio($id)
    {
        return response()->json(Portfolio::where('user_id', $id)->latest()->take(4)->get()->toArray());
    }

    public function destroy(Portfolio $protfolio)
    {
        $protfolio->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Portfolio deleted successfully',
            'data' => Portfolio::where('user_id', auth()->id())->get()->toArray()
        ]);
    }

}
