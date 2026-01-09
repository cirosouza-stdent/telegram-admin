<?php

namespace App\Http\Controllers;

use App\Models\TelegramBot;
use App\Models\TelegramChannel;
use App\Models\TelegramMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Otimizado: Usando uma única query para estatísticas de bots
        $botStats = TelegramBot::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->first();

        // Otimizado: Usando uma única query para estatísticas de canais
        $channelStats = TelegramChannel::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->first();

        // Otimizado: Usando uma única query para estatísticas de mensagens
        $messageStats = TelegramMessage::where('user_id', $userId)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) as scheduled
            ")
            ->first();

        $stats = [
            'total_bots' => (int) $botStats->total,
            'active_bots' => (int) $botStats->active,
            'total_channels' => (int) $channelStats->total,
            'active_channels' => (int) $channelStats->active,
            'total_messages' => (int) $messageStats->total,
            'sent_messages' => (int) $messageStats->sent,
            'pending_messages' => (int) $messageStats->pending,
            'scheduled_messages' => (int) $messageStats->scheduled,
        ];

        $recentMessages = TelegramMessage::where('user_id', $userId)
            ->with('channel:id,name')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $channels = TelegramChannel::where('user_id', $userId)
            ->with('bot:id,name,username')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentMessages', 'channels'));
    }
}