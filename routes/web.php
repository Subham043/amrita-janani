<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\HomePageController;
use App\Http\Controllers\Main\CaptchaController;
use App\Http\Controllers\Main\AboutPageController;
use App\Http\Controllers\Main\ContactPageController;
use App\Http\Controllers\Main\FAQPageController;
use App\Http\Controllers\Main\Auth\LoginPageController;
use App\Http\Controllers\Main\Auth\LogoutPageController;
use App\Http\Controllers\Main\Auth\RegisterPageController;
use App\Http\Controllers\Main\Auth\ForgotPasswordPageController;
use App\Http\Controllers\Main\Auth\ResetPasswordPageController;
use App\Http\Controllers\Main\Auth\VerifyRegisteredUserPageController;
use App\Http\Controllers\Main\Content\DashboardPageController;
use App\Http\Controllers\Main\Content\ImagePageController;
use App\Http\Controllers\Main\Content\AudioPageController;
use App\Http\Controllers\Main\Content\DocumentPageController;
use App\Http\Controllers\Main\Content\VideoPageController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Enquiry\EnquiryController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Image\ImageController;
use App\Http\Controllers\Admin\Document\DocumentController;
use App\Http\Controllers\Admin\Audio\AudioController;
use App\Http\Controllers\Admin\Video\VideoController;
use App\Http\Controllers\Admin\Language\LanguageController;


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
Route::get('/captcha-reload', [CaptchaController::class, 'reloadCaptcha', 'as' => 'captcha.reload'])->name('captcha_ajax');

Route::middleware(['guest'])->group(function () {
    Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('signin');
    Route::post('/sign-in', [LoginPageController::class, 'authenticate', 'as' => 'login.authenticate'])->name('signin_authenticate');
    Route::get('/sign-up', [RegisterPageController::class, 'index', 'as' => 'register.index'])->name('signup');
    Route::post('/sign-up', [RegisterPageController::class, 'store', 'as' => 'register.store'])->name('signup_store');
    Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('forgot_password');
    Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('forgot_password_request');
    Route::get('/reset-password/{id}', [ResetPasswordPageController::class, 'index', 'as' => 'reset_password.index'])->name('resetPassword');
    Route::post('/reset-password/{id}', [ResetPasswordPageController::class, 'requestResetPassword', 'as' => 'reset_password.requestResetPassword'])->name('resetPasswordRequest');
    Route::get('/verify-user/{id}', [VerifyRegisteredUserPageController::class, 'index', 'as' => 'requestVerifyRegisteredUser.index'])->name('verifyUser');
    Route::post('/verify-user/{id}', [VerifyRegisteredUserPageController::class, 'requestVerifyRegisteredUser', 'as' => 'requestVerifyRegisteredUser.requestVerifyRegisteredUser'])->name('requestVerifyRegisteredUser');

    Route::prefix('/admin')->group(function () {
        Route::get('/login', [LoginController::class, 'index', 'as' => 'admin.login'])->name('login');
        Route::post('/authenticate', [LoginController::class, 'authenticate', 'as' => 'admin.authenticate'])->name('authenticate');
        Route::get('/forgot-password', [ForgotPasswordController::class, 'index', 'as' => 'admin.forgot_password'])->name('forgotPassword');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'requestForgotPassword', 'as' => 'admin.requestForgotPassword'])->name('requestForgotPassword');
        Route::get('/reset-password/{id}', [ResetPasswordController::class, 'index', 'as' => 'admin.reset_password'])->name('reset_password');
        Route::post('/reset-password/{id}', [ResetPasswordController::class, 'requestResetPassword', 'as' => 'admin.requestResetPassword'])->name('requestResetPassword');
    });

});


Route::get('/sign-out', [LogoutPageController::class, 'logout', 'as' => 'logout.index'])->middleware(['auth'])->name('signout');
Route::prefix('/content')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardPageController::class, 'index', 'as' => 'content.dashboard'])->name('content_dashboard');
    Route::get('/image', [ImagePageController::class, 'index', 'as' => 'content.image'])->name('content_image');
    Route::get('/image/{uuid}', [ImagePageController::class, 'view', 'as' => 'content.image_view'])->name('content_image_view');
    Route::get('/audio', [AudioPageController::class, 'index', 'as' => 'content.audio'])->name('content_audio');
    Route::get('/document', [DocumentPageController::class, 'index', 'as' => 'content.document'])->name('content_document');
    Route::get('/video', [VideoPageController::class, 'index', 'as' => 'content.video'])->name('content_video');
});

Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
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

    Route::prefix('/image')->group(function () {
        Route::get('/', [ImageController::class, 'view', 'as' => 'admin.image.view'])->name('image_view');
        Route::get('/view/{id}', [ImageController::class, 'display', 'as' => 'admin.image.display'])->name('image_display');
        Route::get('/create', [ImageController::class, 'create', 'as' => 'admin.image.create'])->name('image_create');
        Route::post('/create', [ImageController::class, 'store', 'as' => 'admin.image.store'])->name('image_store');
        Route::get('/excel', [ImageController::class, 'excel', 'as' => 'admin.image.excel'])->name('image_excel');
        Route::get('/edit/{id}', [ImageController::class, 'edit', 'as' => 'admin.image.edit'])->name('image_edit');
        Route::post('/edit/{id}', [ImageController::class, 'update', 'as' => 'admin.image.update'])->name('image_update');
        Route::get('/delete/{id}', [ImageController::class, 'delete', 'as' => 'admin.image.delete'])->name('image_delete');
        Route::get('/bulk-upload', [ImageController::class, 'bulk_upload', 'as' => 'admin.image.bulk_upload'])->name('image_bulk_upload');
        Route::post('/bulk-upload', [ImageController::class, 'bulk_upload_store', 'as' => 'admin.image.bulk_upload_store'])->name('image_bulk_upload_store');
        Route::prefix('/trash')->group(function () {
            Route::get('/', [ImageController::class, 'viewTrash', 'as' => 'admin.image.viewTrash'])->name('image_view_trash');
            Route::get('/restore/{id}', [ImageController::class, 'restoreTrash', 'as' => 'admin.image.restoreTrash'])->name('image_restore_trash');
            Route::get('/restore-all', [ImageController::class, 'restoreAllTrash', 'as' => 'admin.image.restoreAllTrash'])->name('image_restore_all_trash');
            Route::get('/view/{id}', [ImageController::class, 'displayTrash', 'as' => 'admin.image.displayTrash'])->name('image_display_trash');
            Route::get('/delete/{id}', [ImageController::class, 'deleteTrash', 'as' => 'admin.image.deleteTrash'])->name('image_delete_trash');
        });

    });
    
    Route::prefix('/document')->group(function () {
        Route::get('/', [DocumentController::class, 'view', 'as' => 'admin.document.view'])->name('document_view');
        Route::get('/view/{id}', [DocumentController::class, 'display', 'as' => 'admin.document.display'])->name('document_display');
        Route::get('/create', [DocumentController::class, 'create', 'as' => 'admin.document.create'])->name('document_create');
        Route::post('/create', [DocumentController::class, 'store', 'as' => 'admin.document.store'])->name('document_store');
        Route::get('/excel', [DocumentController::class, 'excel', 'as' => 'admin.document.excel'])->name('document_excel');
        Route::get('/edit/{id}', [DocumentController::class, 'edit', 'as' => 'admin.document.edit'])->name('document_edit');
        Route::post('/edit/{id}', [DocumentController::class, 'update', 'as' => 'admin.document.update'])->name('document_update');
        Route::get('/delete/{id}', [DocumentController::class, 'delete', 'as' => 'admin.document.delete'])->name('document_delete');
        Route::get('/bulk-upload', [DocumentController::class, 'bulk_upload', 'as' => 'admin.document.bulk_upload'])->name('document_bulk_upload');
        Route::post('/bulk-upload', [DocumentController::class, 'bulk_upload_store', 'as' => 'admin.document.bulk_upload_store'])->name('document_bulk_upload_store');
        Route::prefix('/trash')->group(function () {
            Route::get('/', [DocumentController::class, 'viewTrash', 'as' => 'admin.document.viewTrash'])->name('document_view_trash');
            Route::get('/restore/{id}', [DocumentController::class, 'restoreTrash', 'as' => 'admin.document.restoreTrash'])->name('document_restore_trash');
            Route::get('/restore-all', [DocumentController::class, 'restoreAllTrash', 'as' => 'admin.document.restoreAllTrash'])->name('document_restore_all_trash');
            Route::get('/view/{id}', [DocumentController::class, 'displayTrash', 'as' => 'admin.document.displayTrash'])->name('document_display_trash');
            Route::get('/delete/{id}', [DocumentController::class, 'deleteTrash', 'as' => 'admin.document.deleteTrash'])->name('document_delete_trash');
        });
    });
    
    Route::prefix('/audio')->group(function () {
        Route::get('/', [AudioController::class, 'view', 'as' => 'admin.audio.view'])->name('audio_view');
        Route::get('/view/{id}', [AudioController::class, 'display', 'as' => 'admin.audio.display'])->name('audio_display');
        Route::get('/create', [AudioController::class, 'create', 'as' => 'admin.audio.create'])->name('audio_create');
        Route::post('/create', [AudioController::class, 'store', 'as' => 'admin.audio.store'])->name('audio_store');
        Route::get('/excel', [AudioController::class, 'excel', 'as' => 'admin.audio.excel'])->name('audio_excel');
        Route::get('/edit/{id}', [AudioController::class, 'edit', 'as' => 'admin.audio.edit'])->name('audio_edit');
        Route::post('/edit/{id}', [AudioController::class, 'update', 'as' => 'admin.audio.update'])->name('audio_update');
        Route::get('/delete/{id}', [AudioController::class, 'delete', 'as' => 'admin.audio.delete'])->name('audio_delete');
        Route::get('/bulk-upload', [AudioController::class, 'bulk_upload', 'as' => 'admin.audio.bulk_upload'])->name('audio_bulk_upload');
        Route::post('/bulk-upload', [AudioController::class, 'bulk_upload_store', 'as' => 'admin.audio.bulk_upload_store'])->name('audio_bulk_upload_store');
        Route::prefix('/trash')->group(function () {
            Route::get('/', [AudioController::class, 'viewTrash', 'as' => 'admin.audio.viewTrash'])->name('audio_view_trash');
            Route::get('/restore/{id}', [AudioController::class, 'restoreTrash', 'as' => 'admin.audio.restoreTrash'])->name('audio_restore_trash');
            Route::get('/restore-all', [AudioController::class, 'restoreAllTrash', 'as' => 'admin.audio.restoreAllTrash'])->name('audio_restore_all_trash');
            Route::get('/view/{id}', [AudioController::class, 'displayTrash', 'as' => 'admin.audio.displayTrash'])->name('audio_display_trash');
            Route::get('/delete/{id}', [AudioController::class, 'deleteTrash', 'as' => 'admin.audio.deleteTrash'])->name('audio_delete_trash');
        });
    });
    
    Route::prefix('/video')->group(function () {
        Route::get('/', [VideoController::class, 'view', 'as' => 'admin.video.view'])->name('video_view');
        Route::get('/view/{id}', [VideoController::class, 'display', 'as' => 'admin.video.display'])->name('video_display');
        Route::get('/create', [VideoController::class, 'create', 'as' => 'admin.video.create'])->name('video_create');
        Route::post('/create', [VideoController::class, 'store', 'as' => 'admin.video.store'])->name('video_store');
        Route::get('/excel', [VideoController::class, 'excel', 'as' => 'admin.video.excel'])->name('video_excel');
        Route::get('/edit/{id}', [VideoController::class, 'edit', 'as' => 'admin.video.edit'])->name('video_edit');
        Route::post('/edit/{id}', [VideoController::class, 'update', 'as' => 'admin.video.update'])->name('video_update');
        Route::get('/delete/{id}', [VideoController::class, 'delete', 'as' => 'admin.video.delete'])->name('video_delete');
        Route::get('/bulk-upload', [VideoController::class, 'bulk_upload', 'as' => 'admin.video.bulk_upload'])->name('video_bulk_upload');
        Route::post('/bulk-upload', [VideoController::class, 'bulk_upload_store', 'as' => 'admin.video.bulk_upload_store'])->name('video_bulk_upload_store');
        Route::prefix('/trash')->group(function () {
            Route::get('/', [VideoController::class, 'viewTrash', 'as' => 'admin.video.viewTrash'])->name('video_view_trash');
            Route::get('/restore/{id}', [VideoController::class, 'restoreTrash', 'as' => 'admin.video.restoreTrash'])->name('video_restore_trash');
            Route::get('/restore-all', [VideoController::class, 'restoreAllTrash', 'as' => 'admin.video.restoreAllTrash'])->name('video_restore_all_trash');
            Route::get('/view/{id}', [VideoController::class, 'displayTrash', 'as' => 'admin.video.displayTrash'])->name('video_display_trash');
            Route::get('/delete/{id}', [VideoController::class, 'deleteTrash', 'as' => 'admin.video.deleteTrash'])->name('video_delete_trash');
        });
    });
    
    Route::prefix('/language')->group(function () {
        Route::get('/', [LanguageController::class, 'view', 'as' => 'admin.language.view'])->name('language_view');
        Route::get('/view/{id}', [LanguageController::class, 'display', 'as' => 'admin.language.display'])->name('language_display');
        Route::get('/create', [LanguageController::class, 'create', 'as' => 'admin.language.create'])->name('language_create');
        Route::post('/create', [LanguageController::class, 'store', 'as' => 'admin.language.store'])->name('language_store');
        Route::get('/excel', [LanguageController::class, 'excel', 'as' => 'admin.language.excel'])->name('language_excel');
        Route::get('/edit/{id}', [LanguageController::class, 'edit', 'as' => 'admin.language.edit'])->name('language_edit');
        Route::post('/edit/{id}', [LanguageController::class, 'update', 'as' => 'admin.language.update'])->name('language_update');
        Route::get('/delete/{id}', [LanguageController::class, 'delete', 'as' => 'admin.language.delete'])->name('language_delete');
    });

    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::get('/logout', [LogoutController::class, 'logout', 'as' => 'admin.logout'])->name('logout');
});