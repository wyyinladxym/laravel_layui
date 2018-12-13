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
Route::group(['prefix' => 'admin'], function () {
    //后台首页
    Route::get('/', 'Admin\IndexController@index');
    Route::get('index/main', 'Admin\IndexController@main');

    //登录
    Route::get('login', 'Admin\LoginController@index');
    Route::post('login', 'Admin\LoginController@login');
    Route::get('login-out', 'Admin\LoginController@loginOut');

    //导航菜单
    Route::get('navs/{id}', 'Admin\IndexController@navs')->where('id', '[0-9]+');

    //轮播图管理
    Route::get('ads/index', 'Admin\AdsController@index');
    Route::get('ads/lists', 'Admin\AdsController@lists');
    Route::post('ads/upload-pic', 'Admin\AdsController@uploadPic');
    Route::post('ads/edit-status/{id}', 'Admin\AdsController@editStatus')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'ads/create', 'Admin\AdsController@create');
    Route::match(['get', 'post'], 'ads/edit/{id}', 'Admin\AdsController@edit')->where('id', '[0-9]+');
    Route::match(['post'], 'ads/destroy', 'Admin\AdsController@destroy');

    //品牌管理
    Route::get('brands/index', 'Admin\BrandsController@index');
    Route::get('brands/lists', 'Admin\BrandsController@lists');
    Route::post('brands/upload-logo', 'Admin\BrandsController@uploadLogo');
    Route::match(['get', 'post'], 'brands/create', 'Admin\BrandsController@create');
    Route::match(['get', 'post'], 'brands/edit/{id}', 'Admin\BrandsController@edit')->where('id', '[0-9]+');
    Route::match(['post'], 'brands/destroy', 'Admin\BrandsController@destroy');

    //文章分类管理
    Route::get('articles-cat/index', 'Admin\ArticlesCatController@index');
    Route::get('articles-cat/lists', 'Admin\ArticlesCatController@lists');
    Route::post('articles-cat/edit-row/{id}', 'Admin\ArticlesCatController@editRow')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'articles-cat/create', 'Admin\ArticlesCatController@create');
    Route::match(['get', 'post'], 'articles-cat/edit/{id}', 'Admin\ArticlesCatController@edit')->where('id', '[0-9]+');
    Route::match(['post'], 'articles-cat/destroy', 'Admin\ArticlesCatController@destroy');

    //文章管理
    Route::get('articles/index', 'Admin\ArticlesController@index');
    Route::get('articles/lists', 'Admin\ArticlesController@lists');
    Route::get('articles/create', 'Admin\ArticlesController@create');
    Route::post('articles/edit-row/{id}', 'Admin\ArticlesController@editRow')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'articles/create', 'Admin\ArticlesController@create');
    Route::match(['get', 'post'], 'articles/edit/{id}', 'Admin\ArticlesController@edit')->where('id', '[0-9]+');
    Route::post('articles/upload-pic', 'Admin\ArticlesController@uploadPic');
    Route::post('articles/upload-video', 'Admin\ArticlesController@uploadVideo');
    Route::match(['post'], 'articles/destroy', 'Admin\ArticlesController@destroy');


    //用户管理
    Route::get('users/index', 'Admin\UsersController@index');
    Route::get('users/create', 'Admin\UsersController@create');

    //系统设置
    Route::get('systems/index', 'Admin\SystemsController@index');
    Route::get('systems/logs', 'Admin\SystemsController@logs');

    //后台管理员
    Route::get('admins/index', 'Admin\adminsController@index');
    Route::get('admins/lists', 'Admin\adminsController@lists');
    Route::post('admins/edit-row/{id}', 'Admin\adminsController@editRow')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'admins/create', 'Admin\adminsController@create');
    Route::match(['get', 'post'], 'admins/edit/{id}', 'Admin\adminsController@edit')->where('id', '[0-9]+');
    Route::post('admins/destroy', 'Admin\adminsController@destroy');

    Route::get('admins/info', 'Admin\adminsController@info');
    Route::get('admins/change_pwd', 'Admin\adminsController@change_pwd');

    //权限管理
    Route::get('auth-rule/index', 'Admin\AuthRuleController@index');
    Route::get('auth-rule/lists', 'Admin\AuthRuleController@lists');
    Route::post('auth-rule/edit-row/{id}', 'Admin\AuthRuleController@editRow')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'auth-rule/create', 'Admin\AuthRuleController@create');
    Route::match(['get', 'post'], 'auth-rule/edit/{id}', 'Admin\AuthRuleController@edit')->where('id', '[0-9]+');
    Route::match(['post'], 'auth-rule/destroy', 'Admin\AuthRuleController@destroy');

    //角色管理
    Route::get('role/index', 'Admin\RoleController@index');
    Route::get('role/lists', 'Admin\RoleController@lists');
    Route::post('role/edit-row/{id}', 'Admin\RoleController@editRow')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'role/create', 'Admin\RoleController@create');
    Route::match(['get', 'post'], 'role/edit/{id}', 'Admin\RoleController@edit')->where('id', '[0-9]+');
    Route::match(['post'], 'role/destroy', 'Admin\RoleController@destroy');
    Route::match(['get', 'post'], 'role/access/{id}', 'Admin\RoleController@access')->where('id', '[0-9]+');


});
Route::controllers([
    'auth-rule' => 'Admin\authRuleController',
    'password' => 'Auth\PasswordController',
]);

Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
