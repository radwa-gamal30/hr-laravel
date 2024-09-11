<?php

namespace App\Http\Controllers;
use App\Models\attendance;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class AttendanceController extends Controller
{
    public function update(Request $request,attendance $attendance){
        $request->validate([
            'employee_id'=>'required|exists:employees,id',
            'salary_action_id'=>'required|exists:salary_actions,id',
            'weekend_id'=>'nullable',
            'holiday_id'=>'nullable',
            'status'=>'required|string|max:255',
            'check_in'=>'required',
            'check_out'=>'required', 
            'date'=>'required', 
            'hours'=>'required', 

        ]);

        $attendance->update($request->all());

        return response()->json([
        'message'=>'attendance updated successfully',
        'data'=>$attendance,
        201]);

    }
    public function destroy(Request $request,attendance $attendance){
        $attendance->delete();
        return response()->json([
            'message'=>'attendance deleted successfully',
            
             201]);
        

    }
    public function getAttendancesByDate()
    {
        $date = '2024-09-11';  

        try {
            $attendances = Attendance::whereDate('date', $date)->get();
            return response()->json($attendances);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
