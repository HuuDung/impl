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

Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/github', 'Auth\LoginController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\LoginController@handleProviderCallback');
    Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('get-repo', 'RepositoryController@get')->name('repo.get');
Route::post('save-repo/{id}', 'RepositoryController@save')->name('repo.save');
Route::get('repo/saved', 'RepositoryController@listSaved')->name('repo.save-list');
Route::get('repo/fork/{id}', 'RepositoryController@fork')->name('repo.fork');

Route::resource('repo', 'RepositoryController');

Route::get('/profile/orther', 'ProfileController@user')->name('profile.orther');

Route::resource('profile', 'ProfileController');
