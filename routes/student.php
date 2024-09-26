<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Class\ClassController;
use App\Http\Controllers\SecondarySection\SecondarySectionController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\SubjectSection\SubjectSectionController;
use App\Http\Controllers\Teacher\TeacherController;
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

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout']);

Route::get('/show_subjects', [SubjectController::class, 'ShowAll']);

Route::get('/show_classes', [ClassController::class, 'ShowAll']);
Route::get('/show_class_subjects', [ClassController::class, 'ShowClassSubjects']);


Route::post('/register', [StudentController::class, 'Create']);

Route::get('/show_teacher_subjects', [TeacherController::class, 'ShowTeacherSubjects']);
Route::get('/show_teacher_classes', [TeacherController::class, 'ShowTeacherClasses']);
Route::get('/show_teachers', [TeacherController::class, 'ShowAll']);

Route::get('/show_subject_sections', [SubjectSectionController::class, 'ShowAll']);
Route::get('/show_secondary_sections', [SubjectSectionController::class, 'ShowSecondarySections']);

Route::get('/show_one_secondary_section', [SecondarySectionController::class, 'ShowById']);
Route::get('/show_one_secondary_section_with_data', [SecondarySectionController::class, 'ShowByIdWithData']);

Route::get('/show_student_bills', [StudentController::class, 'ShowBills'])->middleware('auth:sanctum');
Route::post('/add_orders', [StudentController::class, 'CreateOrders'])->middleware('auth:sanctum');
Route::get('/show_student_orders',[StudentController::class,'ShowOrders'])->middleware('auth:sanctum');
