<?php


use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\WeekendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/' , function(){
    return 'Hello';}
    ) ;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('users', [UserController::class, 'store']);

Route::apiResource('holidays',HolidayController::class);
Route::resource('users', UserController::class);
Route::get('/employee/{id}',[EmployeeController::class,'netSalary']);
Route::resource('weekend', WeekendController::class);
Route::resource('attendance', AttendanceController::class);
Route::get('employee/attendances/{name}', [EmployeeController::class, 'getEmployeeAttendancesByName']);
Route::get('/attendances-by-date', [AttendanceController::class, 'getAttendancesByDate']);
