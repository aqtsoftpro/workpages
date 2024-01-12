<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use App\Models\Skill;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{

    public function updateUserPortfolio($id, Request $request)
    {
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

        $portfolios = $request->all();
        print_r($portfolios['portfolio']);

        foreach($portfolios['portfolio']['name'] as $name_key => $name)
        {
            if($name_key == 0)
            {
                continue;
            }
            
            if(isset($portfolios['portfolio']['portfolioID'][$name_key]) && $portfolios['portfolio']['portfolioID'][$name_key] != '')
                {
                    // echo $name;
                    echo $portfolios['portfolio']['portfolioID'][$name_key];
                    Portfolio::where('id', $portfolios['portfolio']['portfolioID'][$name_key])
                    ->update([
                        'name' => $name,
                        'description' => $portfolios['portfolio']['description'][$name_key],
                        // 'images' => json_encode($portfolio['images']),
                    ]);
                }
                else
                {
                    echo $name;
                    Portfolio::create([
                        'user_id' => $id,
                        'name' => $name,
                        'description' => $portfolios['portfolio']['description'][$name_key],
                        // 'images' => json_encode($portfolio['images']),
                    ]);
                };
            // echo "<pre>";    
            // print_r($portfolio);
            // echo "<pre>"; 
        }

        // echo "<pre>";    
        // print_r($request->all());
        // echo "<pre>";
  
        // return response()->json([
        //             'status' => 'success',
        //             'message' => 'Company deleted!'
        //         ]);
    }

    public function getUserPortfolio($id)
    {
        return response()->json(Portfolio::where('user_id', $id)->get()->toArray());
    }
    


}
