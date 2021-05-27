<?php


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){

    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){
        Route::get("/index","DashboardController@index")->name("index");

        // User Routes
        Route::resource('users','UserController')->except(['show']);

        //Category Routes
        Route::resource('categories','CategoryController')->except(['show']);

        //Product Routes
        Route::resource('products','ProductController')->except(['show']);

        //Product Clients
        Route::resource('clients','ClientController')->except(['Show']);

    });

});



