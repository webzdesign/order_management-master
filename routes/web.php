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

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('/', function () { return redirect('home'); });
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('unauthorized','HomeController@unauthorised')->name('unauthorized');

    Route::get('changepassword','ChangePasswordController@index');
    Route::post('checkOldPassword','ChangePasswordController@checkOldPassword');
    Route::post('updatePassword','ChangePasswordController@changePassword');

    Route::resource('settings', 'SettingController');



    Route::get('getDealerData','DealerController@getDealerData');
    Route::get('dealeractivedeactive/{type}/{id}','DealerController@dealeractivedeactive');
    Route::resource('dealer', 'DealerController');

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
    Route::post('getStateCity', 'PartyController@getStateCity')->middleware('permission:view.parties');
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

    /* Route For Stock Adjustment / Purchase */
    Route::get('purchase','PurchaseController@index')->name('purchase.index')->middleware('permission:view.purchases');
    Route::get('purchase/create','PurchaseController@create')->name('purchase.create')->middleware('permission:create.purchases');
    Route::post('purchase','PurchaseController@store')->name('purchase.store')->middleware('permission:create.purchases');
    Route::get('purchase/{purchase}/edit','PurchaseController@edit')->name('purchase.edit')->middleware('permission:edit.purchases');
    Route::put('purchase/{purchase}','PurchaseController@update')->name('purchase.update')->middleware('permission:edit.purchases');
    Route::get('getPurchaseData', 'PurchaseController@getPurchaseData')->middleware('permission:view.purchases');
    Route::get('purchaseDelete/{purchase}','PurchaseController@destroy')->middleware('permission:delete.purchases');
    /* Route For Product */
    Route::get('product','ProductController@index')->name('product.index')->middleware('permission:view.product');
    Route::get('product/create','ProductController@create')->name('product.create')->middleware('permission:create.product');
    Route::post('product','ProductController@store')->name('product.store')->middleware('permission:create.product');
    Route::get('product/{product}/edit','ProductController@edit')->name('product.edit')->middleware('permission:edit.product');
    Route::put('product/{product}','ProductController@update')->name('product.update')->middleware('permission:edit.product');
    Route::get('getProductData', 'ProductController@getProductData')->middleware('permission:view.product');
    Route::post('checkProductName','ProductController@checkProductName')->middleware('permission:view.product');
    Route::get('productactivedeactive/{type}/{id}','ProductController@productactivedeactive')->middleware('permission:activeinactive.product');

    /* Route For Order */
    Route::get('order','OrderController@index')->name('order.index')->middleware('permission:view.order');
    Route::get('order/create','OrderController@create')->name('order.create')->middleware('permission:create.order');
    Route::post('order','OrderController@store')->name('order.store')->middleware('permission:create.order');
    Route::get('order/{order}/edit','OrderController@edit')->name('order.edit')->middleware('permission:edit.order');
    Route::put('order/{order}','OrderController@update')->name('order.update')->middleware('permission:edit.order');
    Route::get('order/{show}','OrderController@show')->name('order.show')->middleware('permission:view.order');
    Route::get('getOrderData', 'OrderController@getOrderData')->middleware('permission:view.order');
    Route::post('getProductPrice','OrderController@getProductPrice')->middleware('permission:view.order');
    Route::post('getExistOrderDetail','OrderController@getExistOrderDetail')->middleware('permission:view.order');
    Route::post('getDispatchQty','OrderController@getDispatchQty')->middleware('permission:view.order');

    /** Route For Party Report Start*/
    Route::get('partyreport','PartyReportController@index')->name('partyreport.index')->middleware('permission:view.partywisereport');
    Route::get('getPartyReportData', 'PartyReportController@getPartyReportData')->middleware('permission:view.partywisereport');
    Route::post('printPartyReport', 'PartyReportController@printPartyReport')->middleware('permission:view.partywisereport');
    /** Route For Party Report End */

    /** Route For Party Report Start*/
    Route::get('partywisereport','PartyReportController@index')->name('partywisereport.index')->middleware('permission:view.partywisereport');
    Route::get('getPartywiseReportData', 'PartyReportController@getPartyReportData')->middleware('permission:view.partywisereport');
    Route::post('printPartywiseReport', 'PartyReportController@printPartyReport')->middleware('permission:view.partywisereport');
    /** Route For Party Report End */

    /** Route For Product Report Start*/
    Route::get('productwisereport','ProductWiseReportController@index')->name('productwisereport.index');
    Route::get('getProductwiseReportData', 'ProductWiseReportController@getProductWiseReportData');
    Route::post('printProductwiseReport', 'ProductWiseReportController@printProductWiseReport');
    Route::post('getCategoryProduct', 'ProductWiseReportController@getCategoryProduct');
    /** Route For Product Report End */


});
