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

Route::group(['prefix' => 'search'], function() {
    Route::post('company/{demo?}', 'Api\PefindoController@searchCompany');
    Route::post('individu/{demo?}', 'Api\PefindoController@searchIndividu');
});
Route::group(['prefix' => 'report'], function() {
    Route::post('company/{demo?}', 'Api\PefindoController@companyReport');
    Route::post('individu/{demo?}', 'Api\PefindoController@individuReport');
    Route::post('company/pdf/{demo?}', 'Api\PefindoController@companyReportPdf');
});
