<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAuthController;

Route::middleware(['guest'])->name('user.')->controller(UserAuthController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/login', 'login')->name('login');
    Route::get('auth/google', 'redirectToGoogle')->name('redirectToGoogle');
    Route::get('auth/google/callback', 'handleGoogleCallback')->name('handleGoogleCallback');
});

Route::middleware(['auth'])->name('user.')->controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/exchange/{gateway_sn}/{gateway_rc}', 'exchange')->name('exchange');
    Route::get('/image/exchange/{id}/', 'exchangeImage')->name('exchange.image');

    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile', 'profileSubmit')->name('profile.submit');

    Route::get('/transection', 'transection')->name('transection');

    Route::get('/details/exchange', 'exchangeDetails')->name('exchange.details');
    Route::post('/details/exchange/submit', 'exchangeDetailsSubmit')->name('exchange.details.submit');
    Route::post('/submit/exchange', 'exchangeSubmit')->name('exchange.submit');
});

Route::middleware(['admin.guest'])->prefix('admin')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginSubmit')->name('login.submit');
});


Route::middleware(['admin.auth'])->prefix('admin')->controller(SiteController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/logout', 'logout')->name('logout');

    Route::get('/users', 'users')->name('users');
    Route::get('/user/delete/{id}', 'userDelete')->name('user.delete');

    Route::get('/exchange', 'service')->name('service');
    Route::get('/exchange/delete/{id}', 'serviceDelete')->name('service.delete');
    Route::get('/exchange/add', 'add_service')->name('add.service');
    Route::post('/exchange/add', 'add_service_submit')->name('add.service.submit');
    Route::get('/exchange/edit/{id}', 'edit_service')->name('edit.service');
    Route::post('/exchange/edit', 'edit_service_submit')->name('edit.service.submit');

    Route::get('/transection', 'transection')->name('transection');
    Route::get('/transection/delete/{id}', 'transectionDelete')->name('transection.delete');
    Route::post('/transaction/status','transactionStatus')->name('transaction.status');
    Route::get('/transaction/details','transactionDetails')->name('transaction.details');

    Route::post('/search', 'search')->name('search');

    Route::get('/settings', 'settings')->name('settings');
    Route::post('/settings', 'settingsSubmit')->name('settings.submit');

    Route::get('/rates', 'rates')->name('rates');
    Route::get('/rates/delete/{id}', 'ratesDelete')->name('rates.delete');
    Route::get('/rates/add', 'add_rates')->name('add.rates');
    Route::post('/rates/add', 'add_rates_submit')->name('add.rates.submit');
    Route::get('/rates/edit/{id}', 'edit_rates')->name('edit.rates');
    Route::post('/rates/edit', 'edit_rates_submit')->name('edit.rates.submit');

});