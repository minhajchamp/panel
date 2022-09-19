<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Users\BrandsController;
use App\Http\Controllers\Users\ServicesController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Users\DepartmentsController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\PaymentMethodsController;
use App\Http\Controllers\Users\EmailSettingsController;
use App\Http\Controllers\Users\PaymentController;
use Illuminate\Support\Facades\URL;

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

Auth::routes();

Route::get('/', [LoginController::class, 'showLoginForm'])->name('adminGetLogin');
Route::post('/login', [LoginController::class, 'login'])->name('adminPostLogin');
// Route::post('/register', [RegisterController::class, 'store']);
Route::get('stripe-form', [PaymentController::class, 'form'])->name('stripeForm');
Route::post('stripe-form/submit', [PaymentController::class, 'submit'])->name('stripeSubmit');
Route::get('stripe-response/{id}', [PaymentController::class, 'response'])->name('stripeResponse');
Route::middleware(['Users', 'role_id:1'])->prefix('admin')->group(static function () {
    /* Dashboard */
    Route::get('/', [DashboardController::class, 'index']);
    /* Brands */
    Route::get('/brands/index', [BrandsController::class, 'index']);
    Route::get('/brands/create', [BrandsController::class, 'create']);
    Route::get('/brands/edit/{id}', [BrandsController::class, 'edit']);
    Route::post('/brands/store', [BrandsController::class, 'store']);
    Route::post('/brands/update/{id}', [BrandsController::class, 'update']);
    Route::get('/brands/destroy/{id}', [BrandsController::class, 'destroy']);
    Route::get('/brands/mass_destroy', [BrandsController::class, 'mass_destroy']);
    /* Brands */
    Route::get('/services/index', [ServicesController::class, 'index']);
    Route::get('/services/create', [ServicesController::class, 'create']);
    Route::get('/services/edit/{id}', [ServicesController::class, 'edit']);
    Route::post('/services/store', [ServicesController::class, 'store']);
    Route::post('/services/update/{id}', [ServicesController::class, 'update']);
    Route::get('/services/destroy/{id}', [ServicesController::class, 'destroy']);
    Route::get('/services/mass_destroy', [ServicesController::class, 'mass_destroy']);

    Route::resource('departments', DepartmentsController::class);
    Route::get('/users/change_status/{name}/{status_id}/{user_id}', [UserController::class, 'change_status']);
    Route::get('/users/index2', [UserController::class, 'index2']);
    Route::resource('users', UserController::class);
    Route::resource('payment_methods', PaymentMethodsController::class);
    Route::resource('email_methods', EmailSettingsController::class);
    
    Route::get('/smtp_settings/smtp_config', [EmailSettingsController::class, 'smtp_config']);
    Route::post('/smtp_settings/store', [EmailSettingsController::class, 'store_smtp']);

    Route::get('/payment/create', [PaymentController::class, 'create']);
    Route::get('/payment/get_clients/{id}', [PaymentController::class, 'get_clients']);
    Route::get('/payment/get_client/{id}', [PaymentController::class, 'get_client']);

    Route::post('/payment/create_payment_link/', [PaymentController::class, 'create_payment_link']);
    // Route::resource('sub_departments', SubDepartmentsController::class);

});

Route::middleware(['Client', 'role_id:2'])->prefix('client')->namespace('client')->group(static function () {
});


Route::middleware(['Users', 'role_id:3'])->prefix('users')->group(static function () {
    /* Dashboard */
    Route::get('/', [DashboardController::class, 'index']);
    /* Brands */
    Route::get('/brands/index', [BrandsController::class, 'index']);
    /* Services */
    Route::get('/services/index', [ServicesController::class, 'index']);

    Route::resource('departments', DepartmentsController::class);
});

URL::forceScheme('https');