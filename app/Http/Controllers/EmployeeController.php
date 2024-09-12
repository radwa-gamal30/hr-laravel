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
        // Find the employee by name
        $employee = Employee::where('name', $employeeName)->first();

        if (!$employee) {
            return response()->json(['message' => 'No attendances found for this employee'], 404);
        }

        // Get the employee ID
        $employeeId = $employee->id;

        // Find attendances for the employee
        $attendances = attendance::where('employee_id', $employeeId)->get();

        return $attendances;
    }
}
