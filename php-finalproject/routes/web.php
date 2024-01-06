<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student/all', [StudentController::class,'getAllStudents']);
Route::post('/student/add', [StudentController::class,'addStudent']);
Route::put('/student/update/{id}', [StudentController::class, 'updateStudent']);
Route::delete('/student/delete/{id}', [StudentController::class, 'deleteStudent']);