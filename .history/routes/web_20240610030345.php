<?php

use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
Route::get('/',function(){
    return view('welcome');
});
Route::get('/hello',function(){
    return '<h1>Hello World!</h1>';
});
Route::get('/about',function(){
    return view('pages.about');
});
Route::get('/users/{id}',function($id){
    return 'This is user ' . $id;
});
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
