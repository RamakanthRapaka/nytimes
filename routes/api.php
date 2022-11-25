<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BestSellerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BestSellerController::class)->group(function () {
    Route::get('bestseller', 'create')->name('bestseller.create');
    Route::get('topthreebooks', 'topthreebooks')->name('bestseller.topthreebooks');
    Route::get('topthreebooksmail', 'sendEmail')->name('bestseller.sendEmail');
    Route::post('getbookbyid', 'getbookbyid')->name('bestseller.getbookbyid');
    Route::post('updatebookbyid', 'updatebookbyid')->name('bestseller.updatebookbyid');
});
