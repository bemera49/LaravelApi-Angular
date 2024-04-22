<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeesController;

// Company
Route::get('company', [CompanyController::class, 'index']);
Route::get('companies/{id}', [CompanyController::class, 'show']);
Route::post('save/company', [CompanyController::class, 'store']);
Route::post('update/companies/{id}', [CompanyController::class, 'update']);
Route::delete('delete/companies/{id}', [CompanyController::class, 'destroy']);

// Employees
Route::get('employees', [EmployeesController::class, 'index']);
Route::get('employees/{id}', [EmployeesController::class, 'show']);
Route::post('save/employees', [EmployeesController::class, 'store']);
Route::put('update/employees/{id}', [EmployeesController::class, 'update']);
Route::delete('delete/employees/{id}', [EmployeesController::class, 'destroy']);
