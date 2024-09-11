<?php

namespace App\Http\Controllers;
use App\Models\attendance;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class AttendanceController extends Controller
{


    public function index(){
        $attendanceList=attendance::get();
        return response()->json(['data'=>$attendanceList,201]);
    }

    public function store (Request $request){
       $validated=$request->validate([
            'employee_id'=>'required|exists:employees,id',
            'salary_action_id'=>'required|exists:salary_actions,id',
            'weekend_id'=>'nullable',
            'holiday_id'=>'nullable',
            'status'=>'required|string|max:255',
            'check_in'=>'required|date_format:H:i:s',
            'check_out'=>'required|date_format:H:i:s', 
            'date'=>'required|date_format:Y-m-d', 
            'hours'=>'required|numeric', 

        ]);
        $attendance=attendance::create($validated);
        return response()->json([
            'message'=>'attendance added successfully',
            'attendance'=>$attendance,
            201]) ;


    }
            public function show(attendance $attendance){
               $attendance= attendance::find($attendance);
                return response()->json([
                    'message'=>'attendance',
                    'attendance'=>$attendance,
                    201
                ]);
                
            }

    public function update(Request $request,attendance $attendance){
        $validated=$request->validate([
            'employee_id'=>'required|exists:employees,id',
            'salary_action_id'=>'required|exists:salary_actions,id',
            'weekend_id'=>'nullable',
            'holiday_id'=>'nullable',
            'status'=>'required|string|max:255',
            'check_in'=>'required|date_format:H:i:s',
            'check_out'=>'required|date_format:H:i:s', 
            'date'=>'required|date_format:Y-m-d', 
            'hours'=>'required|numeric', 

        ]);

        $attendance->update($validated);

        return response()->json([
        'message'=>'attendance updated successfully',
        'data'=>$attendance,
        201]);

    }
    public function destroy(attendance $attendance){
        $attendance->delete();
        return response()->json([
            'message'=>'attendance deleted successfully',
            
             201]);
        

    }
}
