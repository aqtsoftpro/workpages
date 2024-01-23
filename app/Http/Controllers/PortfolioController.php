<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Requests\PortfolioRequest;

class PortfolioController extends Controller
{

    public function updateUserPortfolio($id, Request $request)
    {
        $inputs = $request->all();

        Portfolio::create([
            'user_id' => auth()->id(),
            'title' => $request->portfolio['title'],
            'description' => $request->portfolio['description'],
            'url' => $request->portfolio['url'],
            'start_date' => null,
            'end_date' => null,
            'skill_used' => $request->portfolio['skill_used'],
            // 'images' => 'ksdfklsd',
            // 'video_links' => 'ksdfklsd',
        ]);

        return response()->json(Portfolio::where('user_id', auth()->id())->get()->toArray());

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
        return response()->json(Portfolio::where('user_id', $id)->get()->toArray());
    }
    


}
