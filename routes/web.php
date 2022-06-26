<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\HomePageController;
use App\Http\Controllers\Main\CaptchaController;
use App\Http\Controllers\Main\AboutPageController;
use App\Http\Controllers\Main\ContactPageController;
use App\Http\Controllers\Main\FAQPageController;
use App\Http\Controllers\Main\LoginPageController;
use App\Http\Controllers\Main\RegisterPageController;
use App\Http\Controllers\Main\ForgotPasswordPageController;
use App\Http\Controllers\Main\ResetPasswordPageController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Enquiry\EnquiryController;
use App\Http\Controllers\Admin\User\UserController;

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
Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('signin');
Route::get('/sign-up', [RegisterPageController::class, 'index', 'as' => 'register.index'])->name('signup');
Route::post('/sign-up', [RegisterPageController::class, 'store', 'as' => 'register.store'])->name('signup_store');
Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('forgot_password');
Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('forgot_password_request');
Route::get('/reset-password/{id}', [ResetPasswordPageController::class, 'index', 'as' => 'reset_password.index'])->name('resetPassword');
Route::post('/reset-password/{id}', [ResetPasswordPageController::class, 'requestResetPassword', 'as' => 'reset_password.requestResetPassword'])->name('resetPasswordRequest');
Route::get('/captcha-reload', [CaptchaController::class, 'reloadCaptcha', 'as' => 'captcha.reload'])->name('captcha_ajax');

Route::prefix('/admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index', 'as' => 'admin.login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate', 'as' => 'admin.authenticate'])->name('authenticate');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index', 'as' => 'admin.forgot_password'])->name('forgotPassword');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'requestForgotPassword', 'as' => 'admin.requestForgotPassword'])->name('requestForgotPassword');
    Route::get('/reset-password/{id}', [ResetPasswordController::class, 'index', 'as' => 'admin.reset_password'])->name('reset_password');
    Route::post('/reset-password/{id}', [ResetPasswordController::class, 'requestResetPassword', 'as' => 'admin.requestResetPassword'])->name('requestResetPassword');
});

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index', 'as' => 'admin.profile'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update', 'as' => 'admin.profile_update'])->name('profile_update');
        Route::post('/profile-password-update', [ProfileController::class, 'profile_password', 'as' => 'admin.profile_password'])->name('profile_password_update');
    });

    Route::prefix('/enquiry')->group(function () {
        Route::get('/', [EnquiryController::class, 'view', 'as' => 'admin.enquiry.view'])->name('enquiry_view');
        Route::get('/view/{id}', [EnquiryController::class, 'display', 'as' => 'admin.enquiry.display'])->name('enquiry_display');
        Route::get('/excel', [EnquiryController::class, 'excel', 'as' => 'admin.enquiry.excel'])->name('enquiry_excel');
        Route::get('/delete/{id}', [EnquiryController::class, 'delete', 'as' => 'admin.enquiry.delete'])->name('enquiry_delete');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'view', 'as' => 'admin.subadmin.view'])->name('subadmin_view');
        Route::get('/view/{id}', [UserController::class, 'display', 'as' => 'admin.subadmin.display'])->name('subadmin_display');
        Route::get('/create', [UserController::class, 'create', 'as' => 'admin.subadmin.create'])->name('subadmin_create');
        Route::post('/create', [UserController::class, 'store', 'as' => 'admin.subadmin.store'])->name('subadmin_store');
        Route::get('/excel', [UserController::class, 'excel', 'as' => 'admin.subadmin.excel'])->name('subadmin_excel');
        Route::get('/edit/{id}', [UserController::class, 'edit', 'as' => 'admin.subadmin.edit'])->name('subadmin_edit');
        Route::post('/edit/{id}', [UserController::class, 'update', 'as' => 'admin.subadmin.update'])->name('subadmin_update');
        Route::get('/delete/{id}', [UserController::class, 'delete', 'as' => 'admin.subadmin.delete'])->name('subadmin_delete');
    });

    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::get('/logout', [LogoutController::class, 'logout', 'as' => 'admin.logout'])->name('logout');
});