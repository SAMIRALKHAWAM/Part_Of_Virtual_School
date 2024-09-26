<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Class\ClassController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\ExamSection\ExamSectionController;
use App\Http\Controllers\primarySection\PrimarySectionController;
use App\Http\Controllers\Question\QuestionController;
use App\Http\Controllers\Question\QuestionTypeController;
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
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout']);

    ////
    Route::middleware('can:Subject Management')
        ->controller(SubjectController::class)->group(function () {
            Route::post('/add_subject', 'Create');
            Route::delete('/delete_subject', 'DeleteBYId');
            Route::post('/edit_subject', 'Update');
            Route::get('/show_one_subject', 'ShowById');
            Route::get('/show_subjects', 'ShowAll');
        });
//////


    Route::middleware('can:Class Management')
        ->controller(ClassController::class)->group(function () {
            Route::post('/add_class', 'Create');
            Route::delete('/delete_class', 'DeleteBYId');
            Route::post('/edit_class', 'Update');
            Route::get('/show_one_class', 'ShowById');
            Route::get('/show_classes', 'ShowAll');
            Route::get('/show_class_subjects', 'ShowClassSubjects');
            Route::post('/edit_class_subjects', 'UpdateClassSubjects');
        });

    ////
    ///
    ///

    Route::middleware('can:Teacher Management')
        ->controller(TeacherController::class)->group(function () {
            Route::post('/add_teacher', 'Create');
            Route::delete('/delete_teacher', 'DeleteBYId');
            Route::get('/show_one_teacher', 'ShowById');
            Route::get('/show_teacher_subjects', 'ShowTeacherSubjects');
            Route::get('/show_teacher_classes', 'ShowTeacherClasses');
            Route::get('/show_teachers', 'ShowAll');
            Route::post('/edit_teacher', 'Update');
            Route::post('/edit_teacher_subjects', 'UpdateTeacherSubjects');
            Route::post('/edit_teacher_classes', 'UpdateTeacherClasses');
            Route::post('/edit_teacher_password', 'UpdateTeacherPassword');
        });

    ////
    ///
    Route::middleware('can:Primary Section Management')
        ->controller(PrimarySectionController::class)->group(function () {
            Route::post('/add_primary_section', 'Create');
            Route::delete('/delete_primary_section', 'DeleteBYId');
            Route::post('/edit_primary_section', 'Update');
            Route::get('/show_one_primary_section', 'ShowById');
            Route::get('/show_primary_sections', 'ShowAll');
        });

    ////
    ///
    Route::middleware('can:Subject Section Management')
        ->controller(SubjectSectionController::class)->group(function () {
            Route::post('/add_subject_section', 'Create');
            Route::delete('/delete_subject_section', 'DeleteBYId');
            Route::get('/show_subject_sections', 'ShowAll');
            Route::get('/show_secondary_sections', 'ShowSecondarySections');
            Route::post('/add_secondary_section', 'CreateSecondarySection');
            Route::get('/show_one_subject_section', 'ShowById');
            Route::post('/edit_subject_section', 'Update');

        });

    Route::middleware('can:Secondary Section Management')
        ->controller(SecondarySectionController::class)->group(function () {


            Route::get('/show_one_secondary_section', 'ShowById');
            Route::get('/show_one_secondary_section_with_data', 'ShowByIdWithData');
            Route::delete('/delete_secondary_section', 'DeleteBYId');
            Route::Post('/edit_secondary_section', 'Update');
            Route::delete('/delete_video', 'DeleteVideoFromCourse');
            Route::delete('/delete_file', 'DeleteFileFromCourse');
            Route::post('/add_video', 'AddVideoToCourse');
            Route::post('/add_file', 'AddFileToCourse');

        });

    Route::middleware('can:Student Management')
        ->controller(StudentController::class)->group(function () {

            Route::get('/show_students', 'ShowAll');
            Route::get('/show_student_bills','ShowBills');
            Route::delete('/delete_student','deleteById');
            Route::post('/change_order_status','ChangeOrderStatus');
            Route::get('/show_student_orders','ShowOrders');
        });

    Route::middleware('can:Exam Management')
        ->controller(ExamController::class)->group(function () {

           Route::post('/add_exam','Create');
        });

    Route::middleware('can:Exam Management')
        ->controller(ExamSectionController::class)->group(function () {

            Route::post('/add_exam_section','Create');
        });

    Route::middleware('can:Exam Management')
        ->controller(QuestionTypeController::class)->group(function () {

            Route::post('/add_question_type','Create');
        });


    Route::middleware('can:Exam Management')
        ->controller(QuestionController::class)->group(function () {

            Route::post('/add_question','Create');
        });
});

