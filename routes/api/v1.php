<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 6:46 PM
 */

use Illuminate\Support\Facades\Route;

Route::get('books', 'BookController@index');
Route::post('books', 'BookController@store');

Route::get('books/{id}', 'BookController@show');
Route::delete('books/{id}', 'BookController@destroy');
Route::patch('books/{id}', 'BookController@update');
