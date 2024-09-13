<?php
namespace App\Http\Controllers;
use App\Models\employee;
use App\Models\attendance;
use Illuminate\Http\Request;
class EmployeeController extends Controller
{
    //
    public function getEmployeeAttendancesByName( $employeeName)
    {
        
        $employee = Employee::where('name', $employeeName)->first();
        if (!$employee) {
            return response()->json(['message' => 'No attendances found for this employee'], 404);
        }
        $employeeId = $employee->id;
        $attendances = attendance::where('employee_id', $employeeId)->get();

        return $attendances;
    }
}
