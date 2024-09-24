<?php

use Illuminate\Support\Facades\Route;


// use App\Http\Controllers\StudentController;



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

// Route::get('/', function () {
//     return view('welcome');
// });
/**Rendering Page **/




Auth::routes();

Route::group(['middleware' => 'guest'], function(){
    
    
});

Route::get('/', 'UserController@showLoginForm');

Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
Route::post('/signin', 'UserController@login_auth');





Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Admin actions
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

Route::middleware(['auth:api', 'role:teacher'])->group(function () {
    // Teacher actions (assign homework, marks, etc.)

});

Route::middleware(['auth:api', 'role:student'])->group(function () {
    // Student actions (view homework, performance tracking, etc.)
});




// Route::middleware(['auth', 'student'])->group(function () {
//     Route::get('/student', 'StudentController@student')->name('student');

//     // Request:
//     Route::post('/student-add', 'StudentController@student_add');
//     Route::post('/student-update/{id}', 'StudentController@student_update');
//     Route::post('/student-delete', 'StudentController@student_delete');
//     Route::get('/student-get', 'StudentController@student_get');
// Route::get('/logout', 'UserController@logout');
    
// });