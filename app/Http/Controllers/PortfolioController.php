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
        if ($id==null) {
            if (Portfolio::where('user_id', $id)->count() >= 7) {
                return response()->json([
                    'status'=> 'success',
                    'data' => Portfolio::with('portfolioImages')->where('user_id', auth()->id())->latest()->get()->toArray(),
                    'message' => 'Portfolio updated successfully'
                ]);
            }
            if ($request->hasFile('other_file')) {
                // Upload the image and store it in the default 'storage' disk
                $imagePath = $request->file('other_file')->store('portfolio/others', 'public');
                // Add the image path to the form data before saving to the database            
                // $inputs['other_file'] = $imagePath;
            }
    
            $portfolio = Portfolio::create([
                'user_id' => auth()->id(),
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
                            'image' => env('APP_URL') .'storage/'. $newImage,
                        ]);
                    }
                }
            }
            
            return response()->json([
                'status'=> 'success',
                'data' => Portfolio::with('portfolioImages')->where('user_id', auth()->id())->latest()->get()->toArray(),
                'message' => 'Portfolio updated successfully'
            ]);

        } else {
            $portfolio = Portfolio::with('portfolioImages')->findOrFail($id);

            if ($request->hasFile('other_file')) {
                // Upload the image and store it in the default 'storage' disk
                $imagePath = $request->file('other_file')->store('portfolio/others', 'public');

            }
    
            $portfolio->update([
                'user_id' => auth()->id(),
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
                        'image' => env('APP_URL').'storage/'. $newImage,
                    ]);
                }
            }

            return response()->json([
                'status'=> 'success',
                'data' => Portfolio::with('portfolioImages')->where('user_id', auth()->id())->latest()->get()->toArray(),
                'message' => 'Portfolio updated successfully'
            ]);
        }

    }

    public function getUserPortfolio($id)
    {
        return response()->json(['status'=> 'success',
            'data' => Portfolio::with('portfolioImages')->where('user_id', $id)->latest()->get()->toArray(),
            'message' => 'Portfolio updated successfully'
        ]);
    }

    public function destroy($protfolio)
    {
        $protfolio = Portfolio::findOrFail($protfolio);
        $userId = $protfolio->user_id;
        $protfolio->delete();
        return response()->json([
            'data' => Portfolio::with('portfolioImages')->where('user_id', $userId)->latest()->take(4)->get()->toArray(),
            'status' => 'success',
            'message' => 'Portfolio deleted successfully'
        ]);
    }

}
