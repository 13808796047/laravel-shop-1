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

Route::get('/', 'PagesController@index')->name('index');


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');
    //开始
    Route::group(['middleware' => 'email_verified'], function () {
        Route::get('test', function () {
            return '你的邮箱已经验证';
        });
    });
    //结束
});
