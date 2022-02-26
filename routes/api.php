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

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin,Customers']],function()
{
    Route::group(['middleware' => ['jwt.verify:SuperAdmin']],function()
    {
        Route::delete('/customers/{id}', 'CustomersController@destroy');
        Route::delete('/orders/{id}', 'OrdersController@destroy');
        Route::delete('/product/{id}', 'ProductController@destroy');
        Route::delete('/detailorders/{id}', 'DetailOrdersController@destroy');
    });

    Route::group(['middleware' => ['jwt.verify:SuperAdmin,Admin']],function()
    {
        Route::post('/customers', 'CustomersController@store');
        Route::put('/customers/{id}', 'CustomersController@update');

        Route::post('/orders', 'OrdersController@store');
        Route::put('/orders/{id}', 'OrdersController@update');

        Route::post('/product', 'ProductController@store');
        Route::put('/product/{id}', 'ProductController@update');

        Route::post('/detailorders', 'DetailOrdersController@store');
        Route::put('/detailorders/{id}', 'DetailOrdersController@update');
    });

    Route::get('/customers', 'CustomersController@show'); 
    Route::get('/customers/{id}', 'CustomersController@detail');

    Route::get('/orders', 'OrdersController@show');
    Route::get('/orders/{id}', 'OrdersController@detail');

    Route::get('/product', 'ProductController@show');
    Route::get('/product/{id}', 'ProductController@detail');

    Route::get('/detailorders', 'DetailOrdersController@show');
    Route::get('/detailorders/{id}', 'DetailOrdersController@detail');
    
});


