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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/v1/products', 'ApiController@products_V1');
Route::any('/v1/purchase', 'ApiController@sellProducts');
Route::any('/v1/productListDetails', 'ApiController@getProductsDetails');
