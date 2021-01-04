<?php


use App\Domain\Album\Album;
use App\Http\Album\Actions\Web\CreateAlbumAction;
use App\Http\Album\Actions\Web\DeleteAlbumAction;
use App\Http\Album\Actions\Web\EditAlbumAction;
use App\Http\Auth\Actions\DashboardAction;
use App\Http\Auth\Controllers\AuthenticatedSessionController;
use App\Http\Auth\Controllers\ConfirmablePasswordController;
use App\Http\Auth\Controllers\EmailVerificationNotificationController;
use App\Http\Auth\Controllers\EmailVerificationPromptController;
use App\Http\Auth\Controllers\NewPasswordController;
use App\Http\Auth\Controllers\PasswordResetLinkController;
use App\Http\Auth\Controllers\RegisteredUserController;
use App\Http\Auth\Controllers\VerifyEmailController;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware(['guest'])
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware(['guest'])
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware(['guest'])
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware(['auth'])
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware(['auth'])
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware(['auth']);

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::get('/dashboard', DashboardAction::class)
    ->name('dashboard')
    ->middleware('auth', 'admin');


Route::prefix('/dashboard/album')->middleware(['auth', 'admin'])->group(function () {
    //edit
    Route::put('{album}', EditAlbumAction::class)->name('dashboard.album-edit');

    //create
    Route::post('/', CreateAlbumAction::class)->name('dashboard.album-create');

    // delete
    Route::delete('/{album}', DeleteAlbumAction::class)->name('dashboard.album-delete');

    //view edit
    Route::get('{album}/edit', [EditAlbumAction::class, 'view'])->name('dashboard.album-edit-view');

    //create view
    Route::get('{album}', [CreateAlbumAction::class, 'view'])->name('dashboard.album-create-view');
});





