<?php


use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Salary_actionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeekendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;



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
    
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected routes (only for authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('holidays', HolidayController::class);
    Route::apiResource('salaryActions',Salary_actionController::class);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('holidays', HolidayController::class);
// });



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('users', [UserController::class, 'store']);


// Route::apiResource('holidays',HolidayController::class);

Route::apiResource('attendances',AttendanceController::class);



Route::get('holidays/month/{month}', [HolidayController::class, 'searchByMonth']);

// Route::get('holidays',[HolidayController::class,'index']);
// Route::get('/holidays/{id}',[HolidayController::class,'show'])->name('holidays.view');

// Route::delete('/holidays/{id}', [HolidayController::class, 'destroy'])->name('holidays.destroy');

// Route::post('/holidays/store',[HolidayController::class,'store'])->name('holidays.store');

// Route::get('/holidays/{id}/edit',[HolidayController::class,'edit'])->name('holidays.edit');

// Route::put('/holidays/{id}/update',[HolidayController::class,'update'])->name('holidays.update');

// Route::get('/holidays/{id}/create',[HolidayController::class,'create'])->name('holidays.create');


Route::resource('salaryaction', Salary_actionController::class);
Route::apiResource('holidays',HolidayController::class);

Route::resource('users', UserController::class);
Route::get('/employee/{id}',[EmployeeController::class,'netSalary']);
Route::resource('weekend', WeekendController::class);
Route::resource('attendance', AttendanceController::class);
Route::get('employee/attendances/{name}', [EmployeeController::class, 'getEmployeeAttendancesByName']);
Route::get('/attendances-by-date', [AttendanceController::class, 'getAttendancesByDate']);
