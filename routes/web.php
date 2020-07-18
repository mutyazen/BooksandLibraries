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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/save', 'HomeController@save')->name('home-save');
Route::post('/home/detail', 'HomeController@detail')->name('home-detail');
Route::post('/home/delete', 'HomeController@delete')->name('home-delete');

Route::get('/library', 'Library\LibraryController@index')->name('library');
Route::post('/library/save', 'Library\LibraryController@save')->name('library-save');
Route::post('/library/detail', 'Library\LibraryController@detail')->name('library-detail');
Route::post('/library/delete', 'Library\LibraryController@delete')->name('library-delete');

Route::get('/book', 'Book\BookController@index')->name('book');
Route::post('/book/save', 'Book\BookController@save')->name('book-save');
Route::post('/book/detail', 'Book\BookController@detail')->name('book-detail');
Route::post('/book/delete', 'Book\BookController@delete')->name('book-delete');
