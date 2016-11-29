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


Route::group(['middleware' => 'shopoauth'], function () {
    //Route::get('/charge_store', 'IndexController@chargeTheStore');
    //Route::get('/activate_charge', 'IndexController@activeApplicationChargeForCurrentStore');
    //Route::group(['middleware' => 'shopify_check_trial_expiration'], function () {
        Route::get('/admin', 'IndexController@admin');
    //});
});


Route::get('/', function(){
    return "Customer Tagging app.(http://nine15.com)";
});
Route::get('/oauth', 'IndexController@oauth');
Route::get('/install', 'IndexController@installApp');
Route::get('/test', 'IndexController@test');
Route::get('/product', 'IndexController@productsdb');
Route::get('/ark/{page}', 'IndexController@ark');
Route::get('/my-jobs', 'IndexController@jobs');

Route::get('/products', 'APIController@getProducts');
Route::post('/products/import', 'APIController@postImportProducts');
Route::get('/get-child-store', 'APIController@getChildStoreSettings');
Route::post('/save-child-store', 'APIController@postSaveChildStoreSettings');


Route::group(['middleware' => 'shopify_webhook'], function () {
    Route::post('/webhooks/test', 'WebhookController@postAddedNewOrder');
    Route::post('/webhooks/customers/create', 'WebhookController@postAddedNewCustomer');
    Route::post('/webhooks/orders/paid', 'WebhookController@postAddedNewOrder');
    Route::post('/app-uninstall', 'WebhookController@appUninstall');
});