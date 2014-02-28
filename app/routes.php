<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Stitch Lite API

// Home
Route::get('stitchlite', function()
{
	//Need to remove this	
	return View::make('slindex');
});


Route::group(array('prefix' => 'stitchlite/api/v1/'), function(){
	Route::resource('products', 'FiveGProductController', array('only' => array('index', 'store', 'create', 'show','edit')));
	Route::resource('sync', 'FiveGProductSyncController', array('only' => array('store')));
	
//	Route::any('authenticate', array('as' => 'authenticate', 'uses' => 'AccountController@authenticate'));
	
});


// Catch-All
App::missing(function($exception){
	return View::make('index');
});

