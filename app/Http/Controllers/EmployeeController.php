<?php

namespace App\Http\Controllers;
use App\Models\employee;
use App\Models\attendance;
use App\Models\salary_actions;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function netSalary($empId)
    {
        //get basic salary of employee
        $employee=employee::find($empId);
        $basicSalary=$employee->salary;
        //get total bonuses
        $totalBonuses = salary_actions::where('employee_id', operator: $empId)
            ->where('type', 'bonus')
            ->sum(column: 'amount');
        // //get total deduction
        $totalDeductions = salary_actions::where('employee_id', $empId)
            ->where('type', 'deduction')
            ->sum('amount');
        $netSalary = $basicSalary + $totalBonuses - $totalDeductions;
        return $netSalary;
    }

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

