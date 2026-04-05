<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ky rresht i krijon 7 rrugë (index, create, store, edit, update, show, destroy)
Route::resource('authors', AuthorController::class);