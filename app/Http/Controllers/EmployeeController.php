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
        //get all attendances of that employee
        $attendances = Attendance::where('employee_id', $empId)->get();
        $totalDaysAttended = $attendances->count();
        //get total working hours of that employee
        $totalHoursWorked = $attendances->sum(function ($attendance) {
            $time1 = Carbon::createFromFormat('H:i:s', time: $attendance->check_in);
            $time2 = Carbon::createFromFormat('H:i:s', time: $attendance->check_out);
            return $time2 ->diffInHours($time1);
        });
        // //get total bonus
        $totalBonuses = salary_actions::where('employee_id', $empId)
            ->where('type', 'bonus')
            ->sum('amount');
        //get total deduction
        $totalDeductions = salary_actions::where('employee_id', $empId)
            ->where('type', 'deduction')
            ->sum('amount');

        $hourlyBonus = ($basicSalary/22)/8;
        $hourlyDeduction = ($basicSalary/22)/8;

        $bonusAmount = $hourlyBonus * $totalHoursWorked;
        $deductionAmount = $hourlyDeduction * $totalHoursWorked;
        // return $totalDaysAttended;

        $netSalary = $basicSalary + $totalBonuses - $totalDeductions - $deductionAmount + $bonusAmount;
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

