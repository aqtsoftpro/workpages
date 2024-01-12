<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\GlobalVariable;
use App\Models\SiteSettings;

class GlobalVariableController extends Controller
{
    public function index(SiteSettings $SiteSettings){
        
        $setting = $SiteSettings::pluck('meta_val', 'meta_key')->all();

        return response()->json($setting);
    }

    public function view(GlobalVariable $globalVariable){
        return response()->json($globalVariable);
    }

    public function store(GlobalVariable $globalVariable, Request $request){
        try{
            $globalVariable->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Global Variable created!',
                'globalVariable' => $globalVariable
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(GlobalVariable $globalVariable, Request $request){
        try{
            $globalVariable->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Global Variable updated!',
                'globalVariable' => $globalVariable
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(GlobalVariable $globalVariable){
        $globalVariable->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'variable deleted!'
        ]);
    }

    public function updateSetting(Request $request){
         $settingFieds =  $request->except('_token');
         foreach($settingFieds as $key => $value){
             GlobalVariable::where('key', $key)->update(['value' => $value]);
         }
         return redirect('/admin/settings/design_settings');
    }
}
