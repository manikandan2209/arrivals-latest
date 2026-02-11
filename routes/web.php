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

Route::middleware(['auth'])->group(function () {
    Route::get('/set-info/list-set', [App\Http\Controllers\SetProductInfoController::class, 'listSet'])->name('set-info.list-set');
    Route::get('/set-info/list-single', [App\Http\Controllers\SetProductInfoController::class, 'listSingle'])->name('set-info.list-single');
    Route::get('/set-info/delete-all', [App\Http\Controllers\SetProductInfoController::class, 'deleteAll'])->name('set-info.delete-all');
    Route::get('/set-info/sync-plytix', [App\Http\Controllers\SetProductInfoController::class, 'syncPlytix'])->name('set-info.sync-plytix');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/sso-login/logs', [App\Http\Controllers\SsoLoginController::class, 'Listlogs'])->name('sso-login.logs');
    Route::get('/sso-login/delete-all', [App\Http\Controllers\SsoLoginController::class, 'deleteAll'])->name('sso-login.delete-all');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/ordermeta/list/{resource}', [App\Http\Controllers\OrderMetaController::class, 'list'])->name('ordermeta.list');
    Route::delete('/ordermeta/delete/{resource}/{reource_id}', [App\Http\Controllers\OrderMetaController::class, 'delete'])->name('ordermeta.delete');

    Route::get('/coupon-cart-log', [App\Http\Controllers\CouponCartLogController::class, 'index'])->name('coupon-cart-log.index');

    Route::get('/plytix/settings', [App\Http\Controllers\PlytixController::class, 'index'])->name('plytix.settings');
    Route::post('/plytix/update', [App\Http\Controllers\PlytixController::class, 'update'])->name('plytix.update');
    Route::get('/plytix/restore', [App\Http\Controllers\PlytixController::class, 'restoreImages'])->name('plytix.restore');

    Route::get('/{site}/coupons-page/{id}/push',[App\Http\Controllers\CouponsPage\CouponsPageController::class, 'pushChangesToBc'])->name('couponspage.push');
    Route::resource('{site}/coupons-page', App\Http\Controllers\CouponsPage\CouponsPageController::class,['names' => 'couponspage']);
    Route::resource('{site}/coupons-page-settings', App\Http\Controllers\CouponsPage\CouponsPageSettingsController::class,['names' => 'couponspagesettings']);
    Route::get('/influence/awards', [App\Http\Controllers\TremendousController::class, 'influenceAwards'])->name('tremendous.influenceAwards');
    Route::get('/tremendous/orders/list', [App\Http\Controllers\TremendousController::class, 'ordersList'])->name('tremendous.orderslist');
    Route::get('/tremendous/settings', [App\Http\Controllers\TremendousController::class, 'settings'])->name('tremendous.settings');
    Route::post('/tremendous/settings/update', [App\Http\Controllers\TremendousController::class, 'settingsUpdate'])->name('tremendous.settings.update');
    Route::get('/tremendous/process-influence-rewards', [App\Http\Controllers\TremendousController::class, 'processInfluenceRewards'])->name('tremendous.process-influence-rewards');

    Route::get('/nr-sr-produtcs/nr-list', [App\Http\Controllers\NRAndSRProductsController::class, 'nrIndex'])->name('nrandsrproducts.nr_index');
    Route::get('/nr-sr-produtcs/sr-list', [App\Http\Controllers\NRAndSRProductsController::class, 'srIndex'])->name('nrandsrproducts.sr_index');
    Route::post('/nr-sr-produtcs/nr-import', [App\Http\Controllers\NRAndSRProductsController::class, 'nrImport'])->name('nrandsrproducts.nr_import');
    Route::post('/nr-sr-produtcs/sr-import', [App\Http\Controllers\NRAndSRProductsController::class, 'srImport'])->name('nrandsrproducts.sr_import');
    Route::get('/nr-sr-produtcs/publish', [App\Http\Controllers\NRAndSRProductsController::class, 'publish'])->name('nrandsrproducts.publish');
    Route::get('/nr-sr-produtcs/re-publish', [App\Http\Controllers\NRAndSRProductsController::class, 'rePublish'])->name('nrandsrproducts.re_publish');


});

require __DIR__.'/auth.php';
