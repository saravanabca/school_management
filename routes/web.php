<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'guest'], function() {
    Route::get('/', 'UserController@showLoginForm');
    Route::post('/signin', 'UserController@login_auth');
});

Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');


// Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/logout', 'UserController@logout');

    Route::middleware(['check.guard:web'])->group(function () {
        Route::get('teacher', 'TeacherController@teacher');
        Route::post('/teacher-add', 'TeacherController@teacher_add');
        Route::post('/teacher-update/{id}', 'TeacherController@teacher_update');
        Route::post('/teacher-delete', 'TeacherController@teacher_delete');
        Route::get('/teacher-get', 'TeacherController@teacher_get');

        Route::get('student', 'StudentController@student');
        Route::post('/student-add', 'StudentController@student_add');
        Route::post('/student-update/{id}', 'StudentController@student_update');
        Route::post('/student-delete', 'StudentController@student_delete');
        Route::get('/student-get', 'StudentController@student_get');
    });

    Route::middleware(['check.guard:teacher'])->group(function () {
        Route::get('/homework', 'TeacherController@homework'); 
        Route::get('/mark', 'TeacherController@mark'); 
        
        Route::post('/homework-add', 'TeacherController@homework_add'); 
        Route::post('/mark-add', 'TeacherController@mark_add');
         
        Route::get('/student-marks', 'TeacherController@get'); 

        Route::get('student', 'StudentController@student');
        Route::post('/student-add', 'StudentController@student_add');
        Route::post('/student-update/{id}', 'StudentController@student_update');
        Route::get('/student-get', 'StudentController@student_get');
    });

    Route::middleware(['check.guard:student'])->group(function () {
        Route::get('/performance/{student_id}', 'StudentController@trackPerformance');
        Route::get('/mark', 'TeacherController@mark'); 
    });
// });