<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalaryActionResource;
use App\Models\salary_actions;

use Illuminate\Http\Request;

class Salary_actionController extends Controller
{
    public function index()
    {
        $Salary = salary_actions::all();
        
        return response()->json([
            'data' => SalaryActionResource::collection($Salary),
            'message' => 'Salary retrieved successfully',
        ], 200);
    }

    public function destroy($id)
     {
        
        $Salary = salary_actions::findOrFail($id);

        
        $Salary->delete();
    
        
        return response()->json([
            'success' => true,
            'message' => 'Salary Action deleted successfully',
        ], 200);
         
     }
     

}
