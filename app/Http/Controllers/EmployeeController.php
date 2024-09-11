<?php

namespace App\Http\Controllers;
use App\Models\employee;
use App\Models\attendance;
use App\Models\salary_actions;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function salary($empId)
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
            return $totalBonuses;
        //get total deduction
        // $totalDeductions = salary_actions::where('employee_id', $empId)
        //     ->where('type', 'deduction')
        //     ->sum('amount');

        // $hourlyBonus = 10;
        // $hourlyDeduction = (($basicSalary/22)/8)*2;

        // $bonusAmount = $hourlyBonus * $totalHoursWorked;
        // $deductionAmount = $hourlyDeduction * $totalHoursWorked;
        // // return $totalDaysAttended;

        // $netSalary = $basicSalary + $totalBonuses - $totalDeductions - $deductionAmount + $bonusAmount;
        // return $netSalary;

    }
}
