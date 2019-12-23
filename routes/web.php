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

    Route::get('changepassword','ChangePasswordController@index');
    Route::post('checkOldPassword','ChangePasswordController@checkOldPassword');
    Route::post('updatePassword','ChangePasswordController@changePassword');

    Route::resource('settings', 'SettingController');

    Route::get('getUserData','UserController@getUserData');
    Route::get('useractivedeactive/{type}/{id}','UserController@useractivedeactive');
    Route::post('checkUserEmail','UserController@checkUserEmail');
    Route::resource('user', 'UserController');

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
    Route::get('role','RoleController@index')->name('role.index');
    Route::get('role/create','RoleController@create')->name('role.create');
    Route::post('role','RoleController@store')->name('role.store');
    Route::get('role/{role}/edit','RoleController@edit')->name('role.edit');
    Route::put('role/{role}','RoleController@update')->name('role.update');
    Route::get('getRoleData', 'RoleController@getRoleData');
    Route::post('checkRoleName','RoleController@checkRoleName');
});
