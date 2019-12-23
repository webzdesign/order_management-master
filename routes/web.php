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

    Route::get('getUserData','UserController@getUserData');
    Route::get('useractivedeactive/{type}/{id}','UserController@useractivedeactive');
    Route::post('checkUserEmail','UserController@checkUserEmail');
    Route::resource('user', 'UserController');


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

    /* Route For State */
    Route::get('state','StateController@index')->name('state.index')->middleware('permission:view.states');
    Route::get('state/create','StateController@create')->name('state.create')->middleware('permission:create.states');
    Route::post('state','StateController@store')->name('state.store')->middleware('permission:create.states');
    Route::get('state/{state}/edit','StateController@edit')->name('state.edit')->middleware('permission:edit.states');
    Route::put('state/{state}','StateController@update')->name('state.update')->middleware('permission:edit.states');
    Route::get('getStateData', 'StateController@getStateData')->middleware('permission:view.states');
    Route::post('checkStateName','StateController@checkStateName')->middleware('permission:view.states');
    Route::get('stateActiveInactive/{type}/{id}','StateController@stateActiveInactive')->middleware('permission:activeinactive.states');

    /* Route For City */
    Route::get('city','CityController@index')->name('city.index')->middleware('permission:view.cities');
    Route::get('city/create','CityController@create')->name('city.create')->middleware('permission:create.cities');
    Route::post('city','CityController@store')->name('city.store')->middleware('permission:create.cities');
    Route::get('city/{city}/edit','CityController@edit')->name('city.edit')->middleware('permission:edit.cities');
    Route::put('city/{city}','CityController@update')->name('city.update')->middleware('permission:edit.cities');
    Route::get('getCityData', 'CityController@getCityData')->middleware('permission:view.cities');
    Route::post('checkCityName','CityController@checkCityName')->middleware('permission:view.cities');
    Route::get('cityActiveInactive/{type}/{id}','CityController@cityActiveInactive')->middleware('permission:activeinactive.cities');

});
