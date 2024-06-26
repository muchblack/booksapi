<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\VerifyUserLogin;


Route::get('/user', [UsersController::class, 'index']);

Route::get('/books', [BooksController::class, 'index']);
Route::post('/books', [BooksController::class, 'store'])->middleware(VerifyUserLogin::class);
Route::delete('/books/{id}', [BooksController::class, 'destroy'])->middleware(VerifyUserLogin::class);
Route::get('/books/{id}', [BooksController::class, 'show']);
Route::put('/books/{id}', [BooksController::class, 'update'])->middleware(VerifyUserLogin::class);

//Route::resource('books', BooksController::class)->middleware(VerifyUserLogin::class);

Route::post('/login', [MainController::class, 'login']);
Route::post('/register', [MainController::class, 'register']);
