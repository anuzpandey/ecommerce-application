<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'site.pages.homepage');
Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');

Auth::routes();
require 'admin.php';

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
