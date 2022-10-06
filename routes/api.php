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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users','UserController');
Route::get('findUser','UserController@search');

Route::apiResource('entities','EntityController');
Route::get('findEntity','EntityController@search');
Route::get('entity',[EntityController::entity,'index']);

Route::apiResource('warehouses','WarehouseController');
Route::get('warehouse',[WarehouseController::entity,'index']);

Route::apiResource('roles','RoleController');

Route::apiResource('costs','CostController');
Route::get('findCost','CostController@search');

Route::apiResource('categories','CategoryController');
Route::get('findCategory','CategoryController@search');

Route::apiResource('products','ProductController');
Route::get('findProduct','ProductController@search');

Route::apiResource('reservations','ReservationController');

Route::get('profile','UserController@profile');
Route::put('profile','UserController@updateProfile');
