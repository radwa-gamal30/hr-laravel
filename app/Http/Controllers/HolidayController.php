<?php

namespace App\Http\Controllers;
use App\Models\Holiday;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HolidayResource;


use Illuminate\Http\Request;

class HolidayController extends Controller
{
    
    public function index()
    {
        $holidays = Holiday::all();

        return response()->json([
            'data' => HolidayResource::collection($holidays),
            'message' => 'Holidays retrieved successfully',
        ], 200);
    }

    function show($id)
     {
           
        $holiday = Holiday::findOrFail($id);
        return response()->json(new HolidayResource($holiday), 200);
     }

     public function store(Request $request)
     {
        // dd($request);
        $validator = Validator::make($request->all(), [
        'name' => 'required|min:5',
        'holiday_date' => 'required|unique:holidays,holiday_date',
    ], [
        'name.required' => "Enter The Name",
        'name.min' => "Name must be at least 5 characters",
        'holiday_date.required' => 'Date is Required',
        'holiday_date.unique' => 'This Date already exists',
    ]);

 
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 400);
    }

    
    $holiday = Holiday::create([
        'name' => $request->name,
        'holiday_date' => $request->holiday_date,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'data' => new HolidayResource($holiday),
        'message' => 'Holiday created successfully',
    ], 201);
     }

     public function update(Request $request, $id)
     {
        //dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'holiday_date' => 'required|unique:holidays,holiday_date,' . $id,
        ], [
            'name.required' => "Enter The Name",
            'name.min' => "Name must be at least 5 characters",
            'holiday_date.required' => 'Date is Required',
            'holiday_date.unique' => 'This Date already exists',
        ]);
    
       
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $holiday = Holiday::findOrFail($id);
    
        $holiday->update($request->all());
    
 
        return response()->json([
            'success' => true,
            'data' => new HolidayResource($holiday),
            'message' => 'Holiday updated successfully',
        ], 200);

     }

     public function destroy($id)
     {
        
        $holiday = Holiday::findOrFail($id);

        
        $holiday->delete();
    
        
        return response()->json([
            'success' => true,
            'message' => 'Holiday deleted successfully',
        ], 200);
         
     }
     
}
