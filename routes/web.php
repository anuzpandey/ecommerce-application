<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'site.pages.homepage');

Auth::routes();
require 'admin.php';

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
