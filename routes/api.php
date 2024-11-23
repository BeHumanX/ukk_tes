<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('categories',CategoryController::class);
Route::apiResource('books',BookController::class);

Route::get('/borrows',[BorrowController::class,'index']);
Route::post('/borrow',[BorrowController::class,'borrow']);