<?php

// Facades
use Illuminate\Support\Facades\Route;

// Admin Login
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PrayerTimeController;

// User Login
// use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\User\Auth\NewPasswordController;
// use App\Http\Controllers\User\Auth\PasswordResetLinkController;
// use App\Http\Controllers\User\Auth\RegisteredUserController;
// use App\Http\Controllers\User\Auth\EmailVerificationController;
// // User Controller
// use App\Http\Controllers\User\UserDashboardController;

/*
|--------------------------------------------------------------------------
|                               Routes For All
|--------------------------------------------------------------------------
*/


/**
 * Errors
 * 
 */
Route::get('error/255', function () {
    return view('errors.255');
})->name('error.255');
Route::get('error/403', function () {
    return view('errors.403');
})->name('error.403');
Route::get('error/404', function () {
    return view('errors.404');
})->name('error.404');
Route::get('error/405', function () {
    return view('errors.405');
})->name('error.405');
Route::get('error/419', function () {
    return view('errors.419');
})->name('error.419');
Route::get('error/500', function () {
    return view('errors.500');
})->name('error.500');

Route::get('/today-prayer-time', function () {
    return view('today-prayer-time');
});

/*
|--------------------------------------------------------------------------
|                         Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::namespace('Auth')->middleware('guest:admin')->group(function () {
        /**
         * Login
         */
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create']);
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store'])->name('login');
    });


    Route::middleware('admin')->group(function () {

        /**
         * Admin Dashboard
         */
        Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        /**
         * Current Auth User Profile and Update
         */
        Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/update-profile', [AdminDashboardController::class, 'updateProfile'])->name('profile.updateProfile');
        Route::post('/profile/update-password', [AdminDashboardController::class, 'updatePassword'])->name('profile.updatePassword');

        /**
         * Login As Client or Login Back as Admin
         */
        Route::get('users/{id}/loginAs', [UserController::class, 'loginAs'])->name('user.loginAs');
        Route::get('login-back', [UserController::class, 'loginBack'])->name('user.login-back');

        /**
         * Admin Users
         */
        Route::resource('staff', StaffController::class);

        /**
         * Namaz Times
         */
        Route::resource('prayer-times', PrayerTimeController::class);
        Route::get('/import-prayer-times', [PrayerTimeController::class, 'importPrayerTimes'])
            ->name('import.prayer.times');
        Route::post('/import-prayer-times', [PrayerTimeController::class, 'importPrayerTimesPost'])
            ->name('import.prayer.times.post');

        /**
         * Clients or Users
         */
        // Route::resource('users', UserController::class);

        /**
         * Logout
         */
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
|                               User Routes
|--------------------------------------------------------------------------
*/
/*
Route::middleware('guest')->group(function () {

    // Registeration
    // Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    // Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password
    Route::get('reset-password/{email}/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // Email Verification
    Route::get('verify-email/{email}/{token}', [EmailVerificationController::class, 'verify'])->name('verify-email');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    
    // User Dashboard
     
    Route::get('/', [UserDashboardController::class, 'dashboard'])->name('dashboard');
});
*/