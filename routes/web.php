<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::resource('users', UserController::class)
    ->names([
        'index' => 'users'
    ])
    ->except(['create', 'show', 'edit']);
Route::redirect('/', '/users');

Route::get('empty', function () {
    return view('empty');
})->name('empty');

