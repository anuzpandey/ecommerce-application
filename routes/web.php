<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'site.pages.homepage');

Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');

Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');

Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');


Auth::routes();
require 'admin.php';

Route::get('/home', 'HomeController@index')->name('home');
