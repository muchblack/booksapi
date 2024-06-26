<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\VerifyUserLogin;

Route::resource('user', UsersController::class)->middleware(VerifyUserLogin::class);
Route::resource('books', BooksController::class)->middleware(VerifyUserLogin::class);
Route::post('/login', [MainController::class, 'login']);
Route::post('/register', [MainController::class, 'register']);
