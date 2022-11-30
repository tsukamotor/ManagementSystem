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
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('products', 'ManagementController');

Route::get('/list', 'ManagementController@showList')->name('list');
Route::get('/home', 'ManagementController@showHome')->name('home');

Route::get('/add', 'ManagementController@showAdd')->name('add');
Route::post('/add', 'ManagementController@update');

Route::get('/edit/{id}', 'ManagementController@showEdit')->name('edit');
Route::patch('/edit/{id}', 'ManagementController@editUpdate');

Route::get('/destroy{id}', 'ManagementController@destroy')->name('destroy');
Route::get('/information/{id}', 'ManagementController@showInformation')->name('information');


