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

    public function search(Request $request)
    {
        $employeeName = $request->input('name');
        $month = $request->input('month'); 
        $year = $request->input('year');   

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        $employeeData = Employee::with(['department', 'attendances' => function($query) use ($startOfMonth, $endOfMonth) {
            
            $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
        }])
        ->where('name', 'LIKE', '%' . $employeeName . '%') 
        ->get()
        ->map(function($employee) {
            return [
                'name' => $employee->name,
                'basic_salary' => $employee->basic_salary,
                'department' => $employee->department->name,
                'total_attendances' => $employee->attendances->count()
            ];
        });

        return response()->json($employeeData);
    }

}

