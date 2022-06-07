<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\HomePageController;
use App\Http\Controllers\Main\AboutPageController;
use App\Http\Controllers\Main\ContactPageController;
use App\Http\Controllers\Main\FAQPageController;
use App\Http\Controllers\Main\LoginPageController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;

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
Route::get('/faq', [FAQPageController::class, 'index', 'as' => 'faq.index'])->name('faq');
Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('login');

Route::prefix('/admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index', 'as' => 'admin.login'])->name('login');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index', 'as' => 'admin.forgot_password'])->name('forgot_password');
    Route::get('/reset-password', [ResetPasswordController::class, 'index', 'as' => 'admin.reset_password'])->name('reset_password');
});