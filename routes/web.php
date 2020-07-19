<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// User Routes
Route::resource('users', 'UserController')->except(['show']);

// Menu Routes
Route::post('menus/categories/restore/{id}', 'MenuCategoryController@restore')->name('categories.restore');
Route::resource('menus/categories', 'MenuCategoryController')->except(['show']);

Route::post('menus/items/restore/{id}', 'MenuItemController@restore')->name('items.restore');
Route::resource('menus/items', 'MenuItemController')->except(['show']);

Route::post('menus/types/restore/{id}', 'MenuTypeController@restore')->name('types.restore');
Route::resource('menus/types', 'MenuTypeController')->except(['show']);

Route::post('menus/restore/{id}', 'MenuController@restore')->name('menus.restore');
Route::resource('menus', 'MenuController');


// Page Routes
Route::resource('pages', 'PageController')->except(['show']);

// Snippet Routes
Route::resource('snippets', 'SnippetController')->except(['show']);
