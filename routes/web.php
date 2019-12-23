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

    Route::get('/', function () { return redirect('home'); });
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

    /* Route For Party */
    Route::get('party','PartyController@index')->name('party.index')->middleware('permission:view.parties');
    Route::get('party/create','PartyController@create')->name('party.create')->middleware('permission:create.parties');
    Route::post('party','PartyController@store')->name('party.store')->middleware('permission:create.parties');
    Route::get('party/{party}/edit','PartyController@edit')->name('party.edit')->middleware('permission:edit.parties');
    Route::put('party/{party}','PartyController@update')->name('party.update')->middleware('permission:edit.parties');
    Route::get('getPartyData', 'PartyController@getPartyData')->middleware('permission:view.parties');
    Route::get('getStateCity', 'PartyController@getStateCity')->middleware('permission:view.parties');
    Route::post('checkPartyMobile','PartyController@checkPartyMobile')->middleware('permission:view.parties');
    Route::get('partyActiveInactive/{type}/{id}','PartyController@partyActiveInactive')->middleware('permission:activeinactive.parties');

    /* Route For Category */
    Route::get('category','CategoryController@index')->name('category.index')->middleware('permission:view.category');
    Route::get('category/create','CategoryController@create')->name('category.create')->middleware('permission:create.category');
    Route::post('category','CategoryController@store')->name('category.store')->middleware('permission:create.category');
    Route::get('category/{category}/edit','CategoryController@edit')->name('category.edit')->middleware('permission:edit.category');
    Route::put('category/{category}','CategoryController@update')->name('category.update')->middleware('permission:edit.category');
    Route::get('getCategoryData', 'CategoryController@getCategoryData')->middleware('permission:view.category');
    Route::post('checkCategoryName','CategoryController@checkCategoryName')->middleware('permission:view.category');
    Route::get('categoryactivedeactive/{type}/{id}','CategoryController@categoryactivedeactive')->middleware('permission:activeinactive.category');


});
