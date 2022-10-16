<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentsController;
use App\Http\Controllers\API\EmployeesController;
use App\Http\Controllers\API\EmployeesAddressesController;
use App\Http\Controllers\API\EmployeesContactsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('departments',DepartmentsController::class)->parameters([
    'update'=>'id',
    'destroy'=>'id'
]);

Route::resource('employees',EmployeesController::class)->parameters([
    'update'=>'id',
    'destroy'=>'id'
]);

Route::resource('employee-address',EmployeesAddressesController::class)->parameters([
    'update'=>'id',
    'destroy'=>'id',
]);

Route::resource('employee-contact',EmployeesContactsController::class)->parameters([
    'update'=>'id',
    'destroy'=>'id',
]);
