<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ComponetController;
use App\Http\Controllers\GourpController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [AuthController::class, 'user']);
});
Route::get('/componet', function () {
    return response()->json(['message' => 'Welcome to the componet endpoint!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/getuser', [AuthController::class, 'getUser']);

Route::get('/componets', [ComponetController::class, 'create']);



Route::get('/show.category',[CategoryController::class,'showCategory'])->name('show.category');
Route::post('/store.category',[CategoryController::class,'storeCategory'])->name('store.category');
Route::delete('/delete.category/{id}',[CategoryController::class,'deleteCategory'])->name('delet.category');
Route::put('/update.category/{id}',[CategoryController::class,'editCategory'])->name('update.category');


