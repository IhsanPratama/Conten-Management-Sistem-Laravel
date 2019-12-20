<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//fitur untuk user tanpa hak akses
Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/blog', function () {
    return view('frontend.blog');
});

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/contact', function () {
    return view('frontend.contact');
});

Route::get('/services', function () {
    return view('frontend.services');
});

Route::get('/portfolio', function () {
    return view('frontend.portfolio');
});

Auth::routes();

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

//fitur untuk user dengan hak akses
Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/artikel', 'ArtikelController@index')->name('artikel');

    Route::post('/artikel', 'ArtikelController@tambah')->name('tambah_artikel');
    Route::post('/artikel/edit', 'ArtikelController@edit')->name('edit_artikel');
    Route::post('/artikel/delete', 'ArtikelController@delete')->name('delete_artikel');

    Route::get('/komentar', 'KomentarController@index')->name('komentar');


});

include "group/komentar.php";

Route::get("/c/{slug}","ArtikelController@kategoriArtikel");

Route::get("/s/{search}","ArtikelController@searchArtikel");

Route::get("/{slug}","ArtikelController@singleArtikel");
