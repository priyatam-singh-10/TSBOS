<?php

use App\Http\Controllers\frontend\ManagePlanController;
use App\Http\Controllers\LeadPurchaseController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
// //Cache clear route
Route::get('/clear-cache', function () {
    // Clear caches
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    //  Artisan::call('optimize'); 
    Cache::flush();

    return 'Application cache cleared and optimized';
});

Route::get('home/switch/{id}', [HomeController::class, 'homepage_switcher'])->name('home.switch');

//Redirect route
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect(route('admin.dashboard'));
    } elseif (auth()->user()->role == 'student') {
        return redirect(route('my.courses'));
    } else {
        return redirect(route('home'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

//Common modal route
Route::get('modal/{view_path}', [ModalController::class, 'common_view_function'])->name('modal');
Route::any('get-video-details/{url?}', [CommonController::class, 'get_video_details'])->name('get.video.details');
Route::get('view/{path}', [CommonController::class, 'rendered_view'])->name('view');

Route::get('closed_back_to_mobile_ber', function () {
    session()->forget('app_url');
    return redirect()->back();
})->name('closed_back_to_mobile_ber');

//Mobile payment redirect
Route::get('payment/web_redirect_to_pay_fee', [PaymentController::class, 'webRedirectToPayFee'])->name('payment.web_redirect_to_pay_fee');

//Installation routes
Route::controller(InstallController::class)->group(function () {
    Route::get('/install_ended', 'index');
    Route::get('install/step0', 'step0')->name('step0');
    Route::get('install/step1', 'step1')->name('step1');
    Route::get('install/step2', 'step2')->name('step2');
    Route::any('install/step3', 'step3')->name('step3');
    Route::get('install/step4', 'step4')->name('step4');
    Route::get('install/step4/{confirm_import}', 'confirmImport')->name('step4.confirm_import');
    Route::get('install/install', 'confirmInstall')->name('confirm_install');
    Route::post('install/validate', 'validatePurchaseCode')->name('install.validate');
    Route::any('install/finalizing_setup', 'finalizingSetup')->name('finalizing_setup');
    Route::get('install/success', 'success')->name('success');
});

Route::get('/get-states/{country}', function ($countryCode) {

    return response()->json(
        DB::table('states')
            ->where('country_id', $countryCode)
            ->select('id', 'name')
            ->get()
    );
})->name('get.states');

Route::get('/get-cities/{state}', function ($state) {
    return response()->json(
        DB::table('cities')
            ->where('state_id', $state)
            ->select('id', 'name')
            ->get()
    );
})->name('get.cities');

Route::get('/get-country-by-code/{code}', function ($code) {

    return DB::table('countries1')
        ->whereRaw('UPPER(iso2) = ?', [strtoupper($code)])
        ->select('id', 'name')
        ->first();
});

//Installation routes

Route::get('/buy-plan', [ManagePlanController::class, 'buyForm']);
Route::post('/buy/checkout', [ManagePlanController::class, 'checkout'])->name('buy.checkout');
Route::any('/buy/payment-success', [ManagePlanController::class, 'paymentSuccess'])->name('buy.payment.success');
Route::get('/thank-you', [ManagePlanController::class, 'thankYou'])->name('thank.you');
Route::get('/join-webinar', [LeadController::class, 'index'])->name('leads.index');
Route::post('/save-lead', [LeadController::class, 'store'])->name('leads.store');
Route::get('/webinar-page', [LeadController::class, 'webinar_page'])->name('webinar-page');
Route::get('/webinar-purchase/payment', [LeadController::class, 'LeadsPayment'])->name('leads.payment');
Route::post('/create-webinar-purchase-order', [LeadPurchaseController::class, 'createOrder'])->name('leads.order');
Route::post('/webinar-purchase/payment-success', [LeadPurchaseController::class, 'paymentSuccess'])->name('leads.payment.success');
// Route::post('razorpay/webhook', [LeadPurchaseController::class, 'razorpayWebhook'])->name('razorpay.webhook');
Route::get('/successful', [LeadController::class, 'ThankYou'])->name('thank-you');
