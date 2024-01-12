<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Language $language){
        return response()->json($language->all());
    }

    public function show(Language $language){
        return response()->json($language);
    }

    public function store(Language $language, Request $request){
        try{
            $newLanguage = $language->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Language Created!',
                'language' => $newLanguage
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Language $language, Request $request){
        try{
            $language->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Language Updated!',
                'language' => $language
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Language $language){
        $language->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Language Deleted!'
        ]);
    }
}
