<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $employees=employee::with('department')->get();
        return response()->json(['data'=>$employees],200);
    }
    public function store(Request $request){
        $validated=$request->validate([
            'name'=>"required|min:3|string|max:255",
            'phone'=>"required|max:15",
            'salary'=>"required|numeric",
            'hire_date'=>"required|date_format:Y-m-d",
            'ssn'=>"required|min:14|unique:employees,ssn",
            'address'=>"required|string|max:255",
            'department_id'=>"required|numeric|exists:departments,id",
            'gender'=>"required|in:male,female",
            'doa'=>"required|date_format:Y-m-d"
        ]);
      

        $employee=employee::create([
            'name'=>$validated['name'],
            'phone'=>$validated['phone'],
            'salary'=>$validated['salary'],
            'hire_date'=>$validated['hire_date'],
            'ssn'=>$validated['ssn'],
            'address'=>$validated['address'],
            'department_id'=>$validated['department_id'],
            'gender'=>$validated['gender'],
            'doa'=>$validated['doa'],
        ]);
       
        // return response()->json([
        //     'message'=>"employee added successfully",
        //     'recently added'=>$employee
        // ],201);
        return response()->json(['message' => 'employee added successfully',
        'recently added' => $employee], 201);

    }

    public function show(employee $employee){
        $employee=employee::with('department')->find($employee);
        return response()->json([
            'employee'=>$employee,
            'status'=>200
        ],200);
    }
    public function update(Request $request,employee $employee){
        $validated=$request->validate([
            'name'=>"required|min:3|string|max:255",
            'phone'=>"required|max:15",
            'salary'=>"required|numeric",
            'hire_date'=>"required|date_format:Y-m-d",
            'ssn'=>"required|min:14|unique:employees,ssn",
            'address'=>"required|string|max:255",
            'department_name'=>"required|string|max:255|unique:departments,name",
            'gender'=>"required|in:male,female",
            'doa'=>"required|date_format:Y-m-d",
        ]);
        //check for dept existance
        $department=department::firstOrCreate(['name',$validated['department_name']]);

        $employee->update([
            'name'=>$validated['name'],
            'phone'=>$validated['phone'],
            'salary'=>$validated['salary'],
            'hire_date'=>$validated['hire_date'],
            'ssn'=>$validated['ssn'],
            'address'=>$validated['address'],
            'department_id'=>$department->id,
            'gender'=>$validated['gender'],
            'doa'=>$validated['doa'],
        ]);
        return response()->json([
            'message'=>"employee updated successfully",
            'recently updated'=>$employee
        ],201);
    }
    public function destroy(Request $request,employee $employee){
        $employee->delete();
        return response()->json([
           'message'=>"employee deleted successfully",
            'employee_deleted'=>$employee
        ],201);

    }
}
