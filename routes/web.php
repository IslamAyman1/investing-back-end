<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('generator');
});
Route::get('user',[\App\Http\Controllers\userController::class,'getUserProject']);
Route::get('userCv',[\App\Http\Controllers\userController::class,'getUserCv']);
Route::get('getJob',[\App\Http\Controllers\userController::class,'getJob']);
Route::get('/send',[\App\Http\Controllers\userController::class,'sendEmail']);
Route::get('testOtp',[\App\Http\Controllers\userAuthController::class,'testOtp']);
Route::group(['middleware'=>'checkToken:user-api'],function(){
    Route::post('generatePdf',[\App\Http\Controllers\userController::class,'generatePdf']);
});
Route::get('getCv',[\App\Http\Controllers\userController::class,'getCv']);