<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\customers\auth\LoginController;
use App\Http\Controllers\customers\auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('admin.dashboard');
})->name('home');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/customers/register', [RegisterController::class, 'index'])->name('customersReg');
Route::post('/customers/register', [RegisterController::class, 'submit'])->name('customersReg_submit');
Route::get('/customers/login', [LoginController::class, 'index'])->name('customersLogin');
Route::post('/customers/login', [LoginController::class, 'submit'])->name('customersLogin_submit');
Route::get('/customers/logout', [LoginController::class, 'logout'])->name('customersLogout');

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('upgrade', function () {return view('pages.upgrade'); })->name('upgrade');
    Route::get('map', function () {return view('pages.maps'); })->name('map');
    Route::get('icons', function () {return view('pages.icons'); })->name('icons');
    Route::get('table-list', function () {return view('pages.tables'); })->name('table');
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

// Share Controller
Route::post('image-upload', [SharedController::class, 'imageUpload'])->name('image-upload');
Route::get('image-remove/{id}/{folder}', [SharedController::class, 'imageRemove'])->name('image-remove');

// Payment
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    // Route::post('{name}', 'XenditPaymentController@update')->name('update');
    Route::post('/va/create', [PaymentController::class, 'createVa'])->name('vaCreate');
    Route::get('/va/list', [PaymentController::class, 'getListVa']);
    Route::post('/va/invoice', [PaymentController::class, 'invoice'])->name('vaInvoice');
    Route::get('/success/{type}', [PaymentController::class, 'success'])->name('xenditSuccess');
    Route::get('/expired/{id}', [PaymentController::class, 'expire'])->name('xenditExpired');
});

// checkout
Route::group(['middleware' => 'customer'], function () {
    Route::get('/checkout-details', [WebController::class, 'checkout_details'])->name('checkout-details');
    Route::get('/checkout-shipping', [WebController::class, 'checkout_shipping'])->name('checkout-shipping');
    Route::get('/checkout-complete', [WebController::class, 'checkout_complete'])->name('checkout-complete');
    Route::get('/checkout-payment', [WebController::class, 'checkout_payment'])->name('checkout-payment');
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment-success');
});
Route::get('/shipping', [WebController::class, 'shipping'])->name('shipping');

// profile
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/edit', [UserController::class, 'edit'])->name('edit');
    Route::post('/update', [UserController::class, 'update'])->name('user-update');
});

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('add', [CartController::class, 'addToCart'])->name('add');
    // Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
    // Route::post('remove', 'CartController@removeFromCart')->name('remove');
    // Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav-cart');
    // Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
});
