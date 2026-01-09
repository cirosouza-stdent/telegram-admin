<?php

namespace App\Policies;

use App\Models\TelegramBot;
use App\Models\User;

class TelegramBotPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TelegramBot $telegramBot): bool
    {
        return $user->id === $telegramBot->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TelegramBot $telegramBot): bool
    {
        return $user->id === $telegramBot->user_id;
    }

    public function delete(User $user, TelegramBot $telegramBot): bool
    {
        return $user->id === $telegramBot->user_id;
    }
}
