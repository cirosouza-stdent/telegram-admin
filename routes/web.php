<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\TelegramChannelController;
use App\Http\Controllers\TelegramMessageController;
use App\Http\Controllers\TelegramWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Telegram routes
    Route::prefix('telegram')->name('telegram.')->group(function () {
        // Bots
        Route::resource('bots', TelegramBotController::class)->parameters(['bots' => 'bot']);
        
        // Channels
        Route::resource('channels', TelegramChannelController::class)->parameters(['channels' => 'channel']);
        
        // Messages
        Route::resource('messages', TelegramMessageController::class)->parameters(['messages' => 'message']);
        Route::post('messages/{message}/send', [TelegramMessageController::class, 'send'])->name('messages.send');
        
        // Telegram Web
        Route::get('web', [TelegramWebController::class, 'index'])->name('web');
    });
});

require __DIR__.'/auth.php';
