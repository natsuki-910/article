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

//「〇〇というアドレスにアクセスをしたら、××という処理を呼び出す」という関連付けのこと→ルーティング
//データを送信するのはpost 表示はshow 実行はexe

//記事一覧画面を表示
Route::get('/', 'ArticleController@showList')->name('articles');
// Route::get('/', 'ArticleController@index')->name('articles');

//記事登録画面を表示
Route::get('/article/create', 'ArticleController@showCreate')->name('create');

//記事登録
Route::post('/article/store', 'ArticleController@exeStore')->name('store');

//記事詳細画面を表示
Route::get('/article/{id}', 'ArticleController@showDetail')->name('show');

//記事編集画面を表示
Route::get('/article/edit/{id}', 'ArticleController@showEdit')->name('edit');

//記事の更新
Route::post('/article/update', 'ArticleController@exeUpdate')->name('update');

//記事の削除
Route::post('/article/delete/{id}', 'ArticleController@exeDelete')->name('delete');
// Route::post('/article/delete', 'ArticleController@exeDelete')->name('delete');
// Route::delete('/article/delete', 'ArticleController@exeDelete')->name('delete');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ユーザー一覧表示画面
Route::get('/user', 'UserController@index')->name('user_index');

// ユーザーの投稿一覧表示画面
Route::get('/show', 'UserController@show')->name('user_show');