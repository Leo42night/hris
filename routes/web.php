<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/users');
Route::get('/users', [UserController::class, 'index']);

Route::get('/empty', function () {
    return view('empty');
})->name('empty');


Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
