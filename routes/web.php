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

// welcome 画面
Route::get('/', function () {
    return view('Kakeibo.welcome');
})->name('welcome');
Route::post('/welcome', 'KakeiboController@register')->name('kRegister');
// ログイン画面
Route::get('/login', function() { return view ('Kakeibo.login');})->name('showLogin');
Route::post('/login', 'KakeiboController@login')->name('login');
// Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('kakeibo/logout', 'KakeiboController@logout')->name('kLogout');

// Route::get('/home', function() {
//     return view('home');
// });
// Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');

// 会員登録
// Route::post('auth/register', 'Auth\RegisterController@register')->name('register');
// Route::get('auth/login', 'Auth\LoginController@showLoginForm');
// Route::post('auth/login', 'Auth\LoginController@login')->name('login');

// Route::get('data', 'testDatabaseController@index')->name('database');
// Route::post('data', 'testDatabaseController@process')->name('process');

// 家計簿
Route::get('kakeibo', 'KakeiboController@index')->name('kakeibo');
Route::post('kakeibo', 'KakeiboController@add')->name('add'); // nameは関数呼び出しの名前
Route::get('kakeibo/test', 'KakeiboController@kTest');
