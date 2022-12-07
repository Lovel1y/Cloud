<?php

use App\Http\Controllers\Api\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group( function () {
    Route::get('show',[App\Http\Controllers\Api\FileController::class,'userInfo']);//
    Route::post('file-manage',[\App\Http\Controllers\Api\FileController::class,'createDirectory']);//
    Route::get('file-manage',[\App\Http\Controllers\Api\FileController::class,'getFiles']);//
    Route::get('get-all-files',[\App\Http\Controllers\Api\FileController::class,'getAllFiles']);//
    Route::delete('file-manage/{file}',[\App\Http\Controllers\Api\FileController::class,'deleteFiles']);//
    Route::post('upload-files',[\App\Http\Controllers\Api\UploadController::class,'upload']);//
    Route::patch('file-manage/{file}',[\App\Http\Controllers\Api\FileController::class,'renameFile']);//
    Route::get('get-all-file-size',[\App\Http\Controllers\Api\FileController::class, 'getAllFileSize']);//
    Route::get('download/{file}',[\App\Http\Controllers\Api\FileController::class, 'downloadFiles']);//
});
Route::post('login', [RegisterController::class, 'login']);//
Route::post('register', [RegisterController::class, 'register']);//
