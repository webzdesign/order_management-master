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
    return view('auth/login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('unauthorized','HomeController@unauthorised')->name('unauthorized');

    Route::get('changepassword','ChangePasswordController@index');
    Route::post('checkOldPassword','ChangePasswordController@checkOldPassword');
    Route::post('updatePassword','ChangePasswordController@changePassword');

    Route::resource('settings', 'SettingController');


    Route::get('getCityData','CityController@getCityData');
    Route::post('checkCityName','CityController@checkCityName');
    Route::resource('city', 'CityController');

    Route::get('getDealerData','DealerController@getDealerData');
    Route::get('dealeractivedeactive/{type}/{id}','DealerController@dealeractivedeactive');
    Route::resource('dealer', 'DealerController');

    Route::get('getCategoryData','CategoryController@getCategoryData');
    Route::get('categoryactivedeactive/{type}/{id}','CategoryController@categoryactivedeactive');
    Route::post('checkCategoryName','CategoryController@checkCategoryName');
    Route::resource('category', 'CategoryController');

    Route::get('getProductData','ProductController@getProductData');
    Route::get('productactivedeactive/{type}/{id}','ProductController@productactivedeactive');
    Route::resource('product', 'ProductController');

    Route::get('getOrderData','OrderController@getOrderData');
    Route::post('checkDispatchQty','OrderController@checkDispatchQty');
    Route::post('getDispatchQty','OrderController@getDispatchQty');
    Route::post('statusAll','OrderController@statusAll');
    Route::resource('order', 'OrderController');

    /* Route for Role */
    Route::get('role','RoleController@index')->name('role.index')->middleware('permission:view.roles');
    Route::get('role/create','RoleController@create')->name('role.create')->middleware('permission:create.roles');
    Route::post('role','RoleController@store')->name('role.store')->middleware('permission:create.roles');
    Route::get('role/{role}/edit','RoleController@edit')->name('role.edit')->middleware('permission:edit.roles');
    Route::put('role/{role}','RoleController@update')->name('role.update')->middleware('permission:edit.roles');
    Route::get('getRoleData', 'RoleController@getRoleData')->middleware('permission:view.roles');
    Route::post('checkRoleName','RoleController@checkRoleName')->middleware('permission:view.roles');

    /** Route for User */
    Route::get('user','UserController@index')->name('user.index')->middleware('permission:view.users');
    Route::get('user/create','UserController@create')->name('user.create')->middleware('permission:create.users');
    Route::post('user','UserController@store')->name('user.store')->middleware('permission:create.users');
    Route::get('user/{user}/edit','UserController@edit')->name('user.edit')->middleware('permission:edit.users');
    Route::put('user/{user}','UserController@update')->name('user.update')->middleware('permission:edit.users');
    Route::get('getUserData','UserController@getUserData')->middleware('permission:view.users');
    Route::get('useractivedeactive/{type}/{id}','UserController@useractivedeactive')->middleware('permission:view.users');
    Route::post('checkUserEmail','UserController@checkUserEmail')->middleware('permission:view.users');

    
});
