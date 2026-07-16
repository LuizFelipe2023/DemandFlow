<?php

use App\Http\Controllers\DemandController;
use App\Http\Controllers\DemandHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('demands.index');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('demands/{id}/pdf', [DemandController::class, 'generateDemandPdf'])
        ->name('demands.pdf');

    Route::patch('demands/{demand}/audit', [DemandController::class, 'audit'])
        ->name('demands.audit');

    Route::resource('demands', DemandController::class);

    Route::resource('demands.histories', DemandHistoryController::class)
        ->only([
            'store',
            'update',
            'destroy'
        ]);

    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::middleware(IsAdmin::class)->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

});