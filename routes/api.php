<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('users', function() {
  return User::all();
})->name('getusers');