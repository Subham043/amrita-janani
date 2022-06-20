<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\HomePageController;
use App\Http\Controllers\Main\AboutPageController;
use App\Http\Controllers\Main\ContactPageController;
use App\Http\Controllers\Main\FAQPageController;
use App\Http\Controllers\Main\LoginPageController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;

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

Route::get('/', [HomePageController::class, 'index', 'as' => 'home.index'])->name('index');
Route::get('/about', [AboutPageController::class, 'index', 'as' => 'about.index'])->name('about');
Route::get('/contact', [ContactPageController::class, 'index', 'as' => 'contact.index'])->name('contact');
Route::post('/contact', [ContactPageController::class, 'contact_ajax', 'as' => 'contact.contact_ajax'])->name('contact_ajax');
Route::get('/faq', [FAQPageController::class, 'index', 'as' => 'faq.index'])->name('faq');
Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('login');

Route::prefix('/admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index', 'as' => 'admin.login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate', 'as' => 'admin.authenticate'])->name('authenticate');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index', 'as' => 'admin.forgot_password'])->name('forgotPassword');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'requestForgotPassword', 'as' => 'admin.requestForgotPassword'])->name('requestForgotPassword');
    Route::get('/reset-password/{id}', [ResetPasswordController::class, 'index', 'as' => 'admin.reset_password'])->name('reset_password');
    Route::post('/reset-password/{id}', [ResetPasswordController::class, 'requestResetPassword', 'as' => 'admin.requestResetPassword'])->name('requestResetPassword');
});

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::get('/logout', [LogoutController::class, 'logout', 'as' => 'admin.logout'])->name('logout');
});