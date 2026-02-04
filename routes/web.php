<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/fedex/cutoff-time', [App\Http\Controllers\FedexController::class, 'index'])->name('fedex.cutoff-time');
    Route::get('/fedex/holidays', [App\Http\Controllers\FedexController::class, 'listholidays'])->name('fedex.holidays');
    Route::post('/fedex/update', [App\Http\Controllers\FedexController::class, 'update'])->name('fedex.update');
    Route::post('/fedex/add-holiday', [App\Http\Controllers\FedexController::class, 'addHoliday'])->name('fedex.add-holiday');
    Route::get('/fedex/delete-holiday/{id}', [App\Http\Controllers\FedexController::class, 'deleteHoliday'])->name('fedex.delete-holiday');
    Route::get('/fedex/cache-clean', [App\Http\Controllers\FedexController::class, 'cacheClean'])->name('fedex.cache-clean');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/banner-settings', [App\Http\Controllers\BannerSettingsController::class, 'index'])->name('banner-settings.index');
    Route::post('/banner-settings/update', [App\Http\Controllers\BannerSettingsController::class, 'update'])->name('banner-settings.update');
});

Route::get('/api/banner-settings', [App\Http\Controllers\BannerSettingsController::class, 'api'])->name('banner-settings.api');

Route::middleware(['auth'])->group(function () {
    Route::get('/{site}/coupon/getcoupondata',[App\Http\Controllers\TbCouponController::class, 'getCouponData'])->name('coupon.getcoupondata');
    Route::resource('/{site}/coupon', App\Http\Controllers\TbCouponController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/credentials', [App\Http\Controllers\CredentialController::class, 'index'])->name('credentials.index');
    Route::patch('/credentials/{id}', [App\Http\Controllers\CredentialController::class, 'update'])->name('credentials.update');
    Route::get('/credentials/plytix', [App\Http\Controllers\CredentialController::class, 'plytixSetInfo'])->name('credentials.plytix-index');
    Route::patch('/credentials/plytix/{id}', [App\Http\Controllers\CredentialController::class, 'updatePlytixSetInfo'])->name('credentials.plytix-update');
    Route::get('/coupon-cart-log', [App\Http\Controllers\CouponCartLogController::class, 'index'])->name('coupon-cart-log.index');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/{site}/coupons-page/{id}/push',[App\Http\Controllers\CouponsPage\CouponsPageController::class, 'pushChangesToBc'])->name('couponspage.push');
    Route::resource('{site}/coupons-page', App\Http\Controllers\CouponsPage\CouponsPageController::class,['names' => 'couponspage']);
    Route::resource('{site}/coupons-page-settings', App\Http\Controllers\CouponsPage\CouponsPageSettingsController::class,['names' => 'couponspagesettings']);
});
require __DIR__.'/auth.php';
