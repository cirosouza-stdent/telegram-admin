<?php

namespace App\Policies;

use App\Models\TelegramChannel;
use App\Models\User;

class TelegramChannelPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TelegramChannel $telegramChannel): bool
    {
        return $user->id === $telegramChannel->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TelegramChannel $telegramChannel): bool
    {
        return $user->id === $telegramChannel->user_id;
    }

    public function delete(User $user, TelegramChannel $telegramChannel): bool
    {
        return $user->id === $telegramChannel->user_id;
    }
}
