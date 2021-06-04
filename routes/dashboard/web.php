<?php


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){

    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){
            Route::get("/","WelcomeController@index")->name("welcome");

        //Category Routes
        Route::resource('categories','CategoryController')->except(['show']);

        //Product Routes
        Route::resource('products','ProductController')->except(['show']);

        //Product Clients , And Order Of Client
        Route::resource('clients','ClientController')->except(['Show']);
        Route::resource('clients.orders','Client\OrderController')->except(['Show']);

        // Order Routes
        Route::resource('orders','OrderController');
        Route::get('/orders/{order}/products','OrderController@products')->name('orders.products');
        // User Routes
        Route::resource('users','UserController')->except(['show']);




    });

});



