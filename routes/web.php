<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {return view('welcome');});
Route::redirect('/','/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/stdhome', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
	Route::resource('/users','UsersController',['except'=>['show','create','store']]);
});

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
});

Route::get('/about/{id}', [App\Http\Controllers\Admin\UsersController::class, 'editmydetails'])->name('edituser');
Route::get('/editmydet/{id}', [App\Http\Controllers\Admin\UsersController::class, 'updatedet'])->name('edituserdetails');


//Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){});
Route::resource('courses','App\Http\Controllers\Admin\CoursesController');
Route::get('/addcourse', [App\Http\Controllers\Admin\CoursesController::class, 'create'])->name('addcourse');
Route::get('/storecourse', [App\Http\Controllers\Admin\CoursesController::class, 'store'])->name('storecourse');
Route::get('/editcourse/{id}', [App\Http\Controllers\Admin\CoursesController::class, 'edit'])->name('editcourse');
Route::get('deletecourse/{id}','App\Http\Controllers\Admin\CoursesController@destroy');

Route::get('/edit/{id}', [App\Http\Controllers\Admin\CoursesController::class, 'update'])->name('edit');
//Route::get('edit/{id}','App\Http\Controllers\Admin\CoursesController@update');
Route::resource('/subjects','App\Http\Controllers\Admin\SubjectsController');
Route::get('/addsubject/{course_id}', [App\Http\Controllers\Admin\SubjectsController::class, 'index'])->name('addsubject');
Route::post('/storesubject', [App\Http\Controllers\Admin\SubjectsController::class, 'store'])->name('storesubject');
Route::get('deletesubject/{id}','App\Http\Controllers\Admin\SubjectsController@destroy');
Route::get('/editsubject/{id}', [App\Http\Controllers\Admin\SubjectsController::class, 'update'])->name('editsubject');
Route::get('/editsub/{id}', [App\Http\Controllers\Admin\SubjectsController::class, 'edit'])->name('editsub');

Route::resource('topics','App\Http\Controllers\Admin\TopicsController');
Route::get('/addtopic/{subject_id}', [App\Http\Controllers\Admin\TopicsController::class, 'index'])->name('addtopic');
Route::post('/storetopic', [App\Http\Controllers\Admin\TopicsController::class, 'store'])->name('storetopics');
Route::get('deletetopic/{id}','App\Http\Controllers\Admin\TopicsController@destroy');

Route::resource('studentcourses','App\Http\Controllers\Student\CoursesController');
Route::get('register/{course}',[App\Http\Controllers\Student\CoursesController::class,'register']);
Route::get('subject/{course}',[App\Http\Controllers\Student\CoursesController::class,'subject']);
Route::get('topic/{subject}',[App\Http\Controllers\Student\TopicController::class,'topic']);
Route::get('choice/{topic}',[App\Http\Controllers\Student\ChoicesController::class,'choice']);
Route::get('/choices', [App\Http\Controllers\Student\ChoicesController::class, 'check'])->name('checkchoice');
Route::get('subject/register/{course}/{subject}',[App\Http\Controllers\Student\CoursesController::class,'register_subject']);
// Route::namespace('App\Http\Controllers\Student')->prefix('student')->name('student.')->middleware('can:students')->group(function(){
// 	Route::resource('/users','UsersController',['except'=>['show','create','store']]);
// });


Route::get('/seeprogress/{id}', [App\Http\Controllers\Admin\CoursesController::class, 'registered'])->name('seeprogress');
Route::get('/seesubprogress/{id}', [App\Http\Controllers\Admin\SubjectsController::class, 'registered'])->name('seesubprogress');
