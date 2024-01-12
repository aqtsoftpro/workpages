<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Qualification;

class QualificationController extends Controller
{
    public function index(Qualification $qualification){
        return response()->json($qualification->all());
    }

    public function show(Qualification $qualification){
        return response()->json($qualification);
    }

    public function store(Qualification $qualification, Request $request){
        try{
            $newQualification = $qualification->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Qualification Created!',
                'qualification' => $newQualification
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Qualification $qualification, Request $request){
        try{
            $qualification->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Qualification Updated!',
                'qualification' => $qualification
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Qualification $qualification){
        $qualification->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Qualification Deleted!'
        ]);
    }
}
