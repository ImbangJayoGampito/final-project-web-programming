<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts\CategoryController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : view('welcome');
});

Auth::routes();
Route::resource('posts', \App\Http\Controllers\Posts\PostController::class)->names('posts');
Route::resource('categories', CategoryController::class)->names('categories');
Route::resource('users', UserController::class)->names('user');
Route::resource('settings', \App\Http\Controllers\SettingsController::class)->names('settings');
Route::get('/products/search', function () {
    // You can add your search logic here or point to a controller
    return 'Search results page';
})->name('products.search');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
