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

Route::get('/', function () {
    return redirect('/login');
});

// BOOKS
Route::get('/books', 'BookController@index');
Route::get('/books/{id}', 'BookController@show');
Route::get('/add/add_book', 'BookController@create');
Route::get('/customer', 'BookController@customerPage');
//END OF BOOKS

//CATEGORIES
Route::get('/categories', 'CategoryController@index');

//END OF CATEGORIES

// BOOK REQUEST
Route::get('/bookrequest/{id}/borrow_form', 'BookRequestController@create');
Route::post('/bookrequest/borrow_form', 'BookRequestController@borrow');

// AUTH
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('isAdmin')->group( function(){

	//ADMIN
	Route::get('/admin/admin_page', 'BookRequestController@index');

	//APPROVE
	Route::put('/admin/{id}/{bid}/{qty}/approve', 'BookRequestController@approve');

	//RETURN
	Route::get('/admin/return_books', 'BookRequestController@returnbooks');
	Route::put('/admin/{id}/{bid}/{bookuser}/{qty}/return', 'BookRequestController@return');

	//DECLINE
	Route::delete('/admin/{id}/{bid}/decline', 'BookRequestController@decline');

	//ADD
	Route::get('/categories/add_category', 'CategoryController@create');
	Route::post('/categories', 'CategoryController@store');

	//EDIT
	Route::get('/categories/{id}/edit', 'CategoryController@edit');
	Route::put('/categories/{id}', 'CategoryController@update');

	//DELETE
	Route::delete('/categories/{id}', 'CategoryController@destroy');

	// ADD
	
	Route::post('/books', 'BookController@store');

	// EDIT
	Route::get('/books/{id}/edit', 'BookController@edit');
	Route::put('/books/{id}', 'BookController@update');

	// DELETE
	Route::delete('/books/{id}','BookController@destroy');

});