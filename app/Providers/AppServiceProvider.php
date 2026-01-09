<?php

namespace App\Providers;

use App\Models\TelegramBot;
use App\Models\TelegramChannel;
use App\Models\TelegramMessage;
use App\Policies\TelegramBotPolicy;
use App\Policies\TelegramChannelPolicy;
use App\Policies\TelegramMessagePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar as policies
        Gate::policy(TelegramBot::class, TelegramBotPolicy::class);
        Gate::policy(TelegramChannel::class, TelegramChannelPolicy::class);
        Gate::policy(TelegramMessage::class, TelegramMessagePolicy::class);
    }
}
