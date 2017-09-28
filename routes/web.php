<?php

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


Auth::routes();

//unauthorized user
Route::get('/unauthorized', function(){
	return view('pages/unauthorized');
});

//student_controller
Route::get('/student', 'Student_Controller@index') -> name('students');
Route::post('/student/{option?}', 'Student_Controller@student');
Route::get('/studentlist', 'Student_Controller@student_list');
Route::get('/student/search', 'Student_Controller@search_by_id_number');
Route::get('/student/{id?}', 'Student_Controller@search_by_id');

//course_controller
Route::post('/course/{option?}', 'Course_Controller@course');

//item_controller
Route::get('/items', 'Item_Controller@index') -> name('items');
Route::post('/item/{option?}', 'Item_Controller@item');
Route::get('/itemlist', 'Item_Controller@item_list');
Route::get('/item/search/{id?}', 'Item_Controller@search_by_id');

//semester_controller
Route::post('/semester/{option?}', 'Semester_Controller@semester');

//department_controller
Route::post('/department/{option?}', 'Department_Controller@department');

//transaction_controller
Route::get('/transaction', 'Transaction_Controller@index') -> name('transaction');
Route::get('/transaction/{option?}', 'Transaction_Controller@transaction');
Route::post('/transaction/{option?}', 'Transaction_Controller@transaction');
Route::post('/transaction/history/{option?}', 'Transaction_Controller@payment_history');

//cashier_controller
Route::get('/cashier', 'Cashier_Controller@index') -> name('cashiers');
Route::get('/cashier/{option?}', 'Cashier_Controller@cashier');

//report_controller
Route::get('/report', 'Report_Controller@index') -> name('reports');
Route::get('/report/by/item', 'Report_Controller@byitem') -> name('item-reports');
Route::get('/report/{option?}', 'Report_Controller@report');

Route::get('/', function(){
	return redirect('/transaction');
});