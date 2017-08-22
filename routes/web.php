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

Route::get('/home', 'HomeController@index') -> name('home');
Route::get('/transaction', 'HomeController@transaction') -> name('transaction');
Route::get('/edit', 'HomeController@edit') -> name('edit');
//student
Route::post('/students/add', 'HomeController@addStudent');
Route::post('/students/delete', 'HomeController@deleteStudent');
Route::post('/students/update', 'HomeController@updateStudent');
//receipt
Route::post('/students/receipt', 'HomeController@insertpayment');
Route::get('/students/transaction/receipt/{opt}/{id}/{acad}/{sem}', 'HomeController@invoice') -> name('receipt');
//Items
Route::post('/items/add', 'HomeController@addItem');
Route::post('/items/delete', 'HomeController@deleteItem');
Route::post('/items/update', 'HomeController@updateItem');
Route::post('/account', 'HomeController@accountUpdate') -> name('account');
Route::get('/student', 'HomeController@student') -> name('students');
Route::get('/student/transaction/{id}', 'HomeController@transaction');
Route::get('/student/{id?}', 'HomeController@transaction');
Route::get('/cashiers', 'HomeController@cashier') -> name('cashiers');
Route::get('/items', 'HomeController@item') -> name('items');
Route::get('/create', 'HomeController@add_student') -> name('add-student');
Route::get('/update', 'HomeController@update_student') -> name('update-student');
Route::get('/stats', 'HomeController@pie_graph');
Route::post('/acadyear','HomeController@acadYear');

Route::get('/temp/{semster}/{acadyear}/{id}','HomeController@tempFilter');

//Route::get('/register', 'HomeController@index') -> name('twitter');

Route::get('/facebook', 'HomeController@facebook') -> name('facebook');

Route::get('/error', function(){
  return view('error_layout.error');
});

Route::get('/', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
  return redirect('/login');
});

// Route::get('/pdf', 'PDFController@index');
// Route::post('send', 'PDFController@postContact');
// Route::post('/face', '');
//email
Route::get('getcontact','HomeController@getContact');
Route::post('postcontact/{opt}/{or}','HomeController@postContact')->name('email');

//pdf
Route::get('/reports', 'HomeController@query') -> name('reports');
Route::get('/reports/filter/{year?}/{sem?}/{acadyear?}/{course?}', 'HomeController@filter') -> name('filter');
Route::get('/reports/csv/{year?}/{sem?}/{acadyear?}/{course?}', 'HomeController@csv') -> name('csv');
Route::get('/reports/pdf/{year?}/{sem?}/{acadyear?}/{course?}', 'HomeController@pdf') -> name('pdf');