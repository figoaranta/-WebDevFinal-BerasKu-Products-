<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function(){
	Route::apiResource('/product','Api\v1\ProductController')->only(['show','destroy','update','store']);
	Route::apiResource('/products','Api\v1\ProductController')->only(['index']);
	Route::post('/productSearch','Api\v1\ProductController@searchGradeType');

	Route::apiResource('/post','Api\v1\PostController')->only(['show','destroy','update','store']);
	Route::apiResource('/posts','Api\v1\PostController')->only(['index']);
	Route::post('/postSerach','Api\v1\PostController@search');
	
	Route::apiResource('/productImages','Api\v1\productImageController')->only(['index']);
	Route::apiResource('/productImage','Api\v1\productImageController')->only(['show','destroy','update','store']);

	Route::delete('/deleteCartAll/{id}/{accountId}','Api\v1\CartController@deleteCartItemAll');
	Route::delete('/deleteCart/{id}/{accountId}', 'Api\v1\CartController@deleteCartItem');
	Route::post('/addToCart/{productId}/{accountId}','Api\v1\CartController@addToCart');
	Route::get('/cart/{id}', 'Api\v1\CartController@viewCart');
});


