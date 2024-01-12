<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(Designation $designation){
        return response()->json($designation->all());
    }

    public function show(Designation $designation){
        return response()->json($designation);
    }

    public function store(Designation $designation, Request $request){
        try{
            $newDesignation = $designation->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Designation Created!',
                'designation' => $newDesignation
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Designation $designation, Request $request){
        try{
            $designation->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Designation Updated!',
                'designation' => $designation
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Designation $designation){
        $designation->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Designation Deleted!'
        ]);
    }
}
