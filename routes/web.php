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

//記事一覧画面と検索を表示する
Route::get('/', 'ArticleController@showList')->name('articles');

//記事登録画面を表示する
Route::get('/article/create', 'ArticleController@showCreate')->name('create');

//記事を登録する
Route::post('/article/store', 'ArticleController@exeStore')->name('store');

//記事詳細画面を表示する
Route::get('/article/{id}', 'ArticleController@showDetail')->name('show');

//記事編集画面を表示する
Route::get('/article/edit/{id}', 'ArticleController@showEdit')->name('edit');

//記事を更新する
Route::post('/article/update', 'ArticleController@exeUpdate')->name('update');

//記事を削除する
Route::post('/article/delete/{id}', 'ArticleController@exeDelete')->name('delete');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

