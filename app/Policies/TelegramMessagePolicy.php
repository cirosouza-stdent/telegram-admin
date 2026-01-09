<?php

namespace App\Policies;

use App\Models\TelegramMessage;
use App\Models\User;

class TelegramMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TelegramMessage $telegramMessage): bool
    {
        return $user->id === $telegramMessage->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TelegramMessage $telegramMessage): bool
    {
        return $user->id === $telegramMessage->user_id;
    }

    public function delete(User $user, TelegramMessage $telegramMessage): bool
    {
        return $user->id === $telegramMessage->user_id;
    }
}
