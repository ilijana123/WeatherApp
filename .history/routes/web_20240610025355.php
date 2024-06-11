<?php

use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
Route::get('/',function(){
    return 'Hello World!';
});
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
