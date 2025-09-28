<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    DashboardController, SaleController, ProductController,
    CustomerController
};

/*
* *****************
* AUTHENTICATION
* **************** */
Route::group(['prefix'=>'auth'], function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
});


Route::name("admin.")->middleware('auth')->prefix('admin')->group(function()
{
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    /*
    * *****************
    * SALE MODULE
    * ************** */
    Route::name('sales.')->prefix('sales')->group(function(){
        Route::match(['get', 'post'], 'list', [SaleController::class, 'list'])->name('list');
        Route::get('create', [SaleController::class, 'create'])->name('create');
        Route::post('store', [SaleController::class, 'store'])->name('store');
        Route::get('/{sale}', [SaleController::class, 'show'])->name('show');
        Route::get('/{sale}/destroy', [SaleController::class, 'destroy'])->name('destroy');
        Route::get('/{sale}/restore', [SaleController::class, 'restore'])->name('restore');

        //
        Route::group(['prefix'=>'trash'], function(){
            Route::match(['GET', 'POST'], 'list', [SaleController::class, 'trashList'])->name('trash.list');
            Route::get('recovery', [SaleController::class, 'recovery'])->name('trash.recovery');
        });
    });


    /*
    * *****************
    * PRODUCT MODULE
    * ************** */
    Route::name('products.')->prefix('products')->group(function () {
        Route::resource('/', ProductController::class);
    });


    /*
    * *****************
    * CUSTOMER MODULE
    * ************** */
    Route::name('customer.')->prefix('customer')->group(function(){
        Route::resource('/', CustomerController::class);
    });
});




Route::get('/', function () {
    return redirect()->to(route('login'));
});
