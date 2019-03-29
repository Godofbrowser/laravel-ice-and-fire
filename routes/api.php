<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
	'namespace' => 'Services'
], function() {
	require __DIR__ . '/api/services.php';
});

Route::group([
	'namespace' => 'V1',
	'prefix' => 'v1'
], function() {
	require __DIR__ . '/api/v1.php';
});

