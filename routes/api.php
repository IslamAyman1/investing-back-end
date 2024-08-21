<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::group(['prefix'=>'user','middleware'=>'api'],function(){
    Route::post('userRegister',[App\Http\Controllers\userAuthController::class,'userRegister']);
    Route::post('sendEmail',[App\Http\Controllers\userAuthController::class,'sendEmail']);
    Route::post('checkCode',[App\Http\Controllers\userAuthController::class,'checkCode']);
    Route::post('userLogin',[App\Http\Controllers\userAuthController::class,'userLogin']);
    Route::post('forgetPassword',[App\Http\Controllers\userAuthController::class,'checkEmailAndSendCode']);
    Route::get('CheckSendedCode/{code}',[App\Http\Controllers\userAuthController::class,'CheckSendedCode']);
    Route::post('addInvestingProject',[App\Http\Controllers\userAuthController::class,'addInvestingProject']);
    Route::get('getInvestingProject',[App\Http\Controllers\userAuthController::class,'getInvestingProject']);
    Route::get('investingPagination',[App\Http\Controllers\userAuthController::class,'investingPagination']);
    Route::get('freelancePagination',[App\Http\Controllers\userAuthController::class,'freelancePagination']);
    Route::group(['middleware'=>'checkToken:user-api'],function(){
        Route::post('getUserData',[App\Http\Controllers\userAuthController::class,'userProfile']);
        Route::post('updateProfile',[App\Http\Controllers\userAuthController::class,'updateProfile']);
        Route::post('addInvestingProject',[App\Http\Controllers\userAuthController::class,'addInvestingProject']);
        Route::post('addFreelanceProject',[App\Http\Controllers\userAuthController::class,'addFreelanceProject']);
        Route::post('logout',[App\Http\Controllers\userAuthController::class,'logout']);
        Route::post('checkTokenStatus',[App\Http\Controllers\userAuthController::class,'checkTokenStatus']);
        Route::post('addCv',[App\Http\Controllers\userAuthController::class,'addCv']);
        Route::post('getCvInfo',[App\Http\Controllers\userAuthController::class,'getCvInfo']);
        Route::post('addJob',[App\Http\Controllers\userAuthController::class,'addJob']);
        Route::post('generatePdf',[\App\Http\Controllers\userAuthController::class,'generatePdf']);
        Route::post('getUserProjects',[\App\Http\Controllers\userAuthController::class,'getUserProjects']);
        Route::get('getUserProjects',[\App\Http\Controllers\userAuthController::class,'getUserProjects']);
     
      }); 
      Route::post('search',[App\Http\Controllers\userAuthController::class,'search']);
      Route::post('searchFreelance',[App\Http\Controllers\userAuthController::class,'searchFreelance']);
      Route::get('getImage',[App\Http\Controllers\userAuthController::class,'getImage']);
      Route::get('testRelation',[App\Http\Controllers\userAuthController::class,'testRelation']);
});
// Route::group([]); 

// Route::group(['prefix'=>'test'],function(){
//   Route::get('getData',[\App\Http\Controllers\userAuthController::class,'getData']);
// });