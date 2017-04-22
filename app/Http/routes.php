<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', 'StaticPagesController@home')->name('home');
get('/help', 'StaticPagesController@help')->name('help');
get('/about', 'StaticPagesController@about')->name('about');

get('signup','UserController@create')->name('signup');
resource('users','UserController');
//get('/users', 'UsersController@index')->name('users.index');
//get('/users/{id}', 'UsersController@show')->name('users.show');
//get('/users/create', 'UsersController@create')->name('users.create');
//post('/users', 'UsersController@store')->name('users.store');
//get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
//patch('/users/{id}', 'UsersController@update')->name('users.update');
//delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');
//HTTP 请求	URL	动作	作用
//GET	/users	UsersController@index	显示所有用户列表的页面
//GET	/users/1	UsersController@show	显示用户个人信息的页面
//GET	/users/create	UsersController@create	创建用户的页面
//POST	/users	UsersController@store	创建用户
//GET	/users/{id}/edit	UsersController@edit	编辑用户个人资料的页面
//PATCH	/users/{id}	UsersController@update	更新用户
//DELETE	/users/{id}	UsersController@destroy	删除用户
get('login', 'SessionsController@create')->name('login');
post('login', 'SessionsController@store')->name('login');
delete('logout', 'SessionsController@destroy')->name('logout');
/**
 * 新增的路由功能如下。

HTTP 请求	URL	动作	作用
GET	/login	SessionsController@create	显示登录页面
POST	/login	SessionsController@store	创建新会话（登录）
DELETE	/logout	SessionsController@destroy	销毁会话（退出登录）
 */