<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/employees', [EmployeeController::class,'index'])->name('employees.list');
Route::post('/employees/get-data', [EmployeeController::class,'getData'])->name('employees.getData');
Route::get('/employees/create', [EmployeeController::class,'create'])->name('employees.create');
Route::post('/employees/store', [EmployeeController::class,'store'])->name('employees.store');
Route::get('/employees/edit/{id}', [EmployeeController::class,'edit'])->name('employees.edit');
Route::post('/employees/update', [EmployeeController::class,'update'])->name('employees.update');
Route::post('/employees/delete', [EmployeeController::class,'delete'])->name('employees.delete');