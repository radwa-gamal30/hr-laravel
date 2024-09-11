<?php

namespace App\Http\Controllers;
use App\Models\attendance;
use Carbon\Carbon;
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
            'check_in'=>'required|date_format:H:i:s',
            'check_out'=>'required|date_format:H:i:s', 
            'date'=>'required|date_format:Y-m-d', 

        ]);
        $check_in=new Carbon($validated['check_in']);
        $check_out=new Carbon($validated['check_out']);
        $hours=$check_out->diffInHours($check_in);

        if($hours==0){
            $status='absent';
        }
        elseif($hours==8){
            $status='present';
        }
        elseif($hours>8){
            $status='bonus';
        }else{
            $status='deduction';
        }
        $attendance=attendance::create([
            'employee_id'=>$validated['employee_id'],
            'salary_action_id'=>$validated['salary_action_id'],
            'weekend_id'=>$validated['weekend_id'],
            'check_in'=>$validated['check_in'],
            'check_out'=>$validated['check_out'],
            'date'=>$validated['date'],
            'hours'=>$hours,
            'status'=>$status,
        ]);
        return response()->json([
            'message'=>'attendance added successfully',
            'attendance'=>$attendance,
            'hours'=>$hours,
            'status'=>$status,
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
