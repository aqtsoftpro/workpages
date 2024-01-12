<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyTypeController extends Controller
{
    public function index(CompanyType $companyType){
        return response()->json($companyType->all());
    }

    public function show(CompanyType $companyType){
        return response()->json($companyType);
    }

    public function store(CompanyType $companyType, Request $request){
        try{
            $companyType->create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Company Type created successfully',
                'companyType' => $companyType
            ]);
        }   catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function update(CompanyType $companyType, Request $request){
        try{
            $companyType->update($request->all());
            return response()->json([
                'status' => 'companyType updated',
                'message' => 'Company Type updated successfully',
                'companyType' => $companyType
            ]);
        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(CompanyType $companyType){
        $companyType->delete();
        return response()->json([
            'status' => 'companyType deleted',
            'message' => 'Company Type deleted successfully'
        ]);
    }

    public function filter_company_type()
    {
        
        $company_types = DB::table('company_types')
        ->Join('companies', 'company_types.id', '=', 'companies.company_type_id')
        ->select( 'companies.company_type_id', DB::raw('COUNT(companies.id) as counts'))
        ->groupBy('companies.company_type_id')
        ->orderBy('company_types.name', 'DESC')
        ->get();
  
        $company_types_filter_with_count = array();
        $i = 0;
        foreach($company_types as $company_type)
        {
            $getType = CompanyType::where('id', $company_type->company_type_id)->first()->toArray();
            $company_types_filter_with_count[$i]['id'] = $company_type->company_type_id;
            $company_types_filter_with_count[$i]['name'] = $getType['name'];
            $company_types_filter_with_count[$i]['counts'] = $company_type->counts;
            $i++;
        }

        return response()->json($company_types_filter_with_count);
    }
}
