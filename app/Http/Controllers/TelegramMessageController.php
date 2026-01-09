<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramMessageRequest;
use App\Http\Requests\UpdateTelegramMessageRequest;
use App\Models\TelegramChannel;
use App\Models\TelegramMessage;
use Illuminate\Support\Facades\Http;

class TelegramMessageController extends Controller
{
    public function index()
    {
        $messages = TelegramMessage::where('user_id', auth()->id())
            ->with('channel:id,name')
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('telegram.messages.index', compact('messages'));
    }

    public function create()
    {
        $channels = TelegramChannel::where('user_id', auth()->id())
            ->where('is_active', true)
            ->with('bot:id,name')
            ->select('id', 'name', 'telegram_bot_id')
            ->get();
        return view('telegram.messages.create', compact('channels'));
    }

    public function store(StoreTelegramMessageRequest $request)
    {
        $validated = $request->validated();

        $message = TelegramMessage::create([
            'user_id' => auth()->id(),
            'telegram_channel_id' => $validated['telegram_channel_id'],
            'content' => $validated['content'],
            'status' => isset($validated['scheduled_at']) ? 'scheduled' : 'pending',
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        if (!isset($validated['scheduled_at'])) {
            $this->sendMessage($message);
        }

        return redirect()->route('telegram.messages.index')
            ->with('success', 'Mensagem criada com sucesso!');
    }

    public function show(TelegramMessage $message)
    {
        $this->authorize('view', $message);
        $message->load('channel:id,name');
        return view('telegram.messages.show', compact('message'));
    }

    public function edit(TelegramMessage $message)
    {
        $this->authorize('update', $message);
        $channels = TelegramChannel::where('user_id', auth()->id())
            ->where('is_active', true)
            ->select('id', 'name')
            ->get();
        return view('telegram.messages.edit', compact('message', 'channels'));
    }

    public function update(UpdateTelegramMessageRequest $request, TelegramMessage $message)
    {
        $message->update($request->validated());

        return redirect()->route('telegram.messages.index')
            ->with('success', 'Mensagem atualizada com sucesso!');
    }

    public function destroy(TelegramMessage $message)
    {
        $this->authorize('delete', $message);
        $message->delete();

        return redirect()->route('telegram.messages.index')
            ->with('success', 'Mensagem removida com sucesso!');
    }

    public function send(TelegramMessage $message)
    {
        $this->authorize('update', $message);
        $this->sendMessage($message);
        
        return redirect()->route('telegram.messages.index')
            ->with('success', 'Mensagem enviada com sucesso!');
    }

    private function sendMessage(TelegramMessage $message): bool
    {
        $channel = $message->channel;
        $bot = $channel?->bot;

        if (!$bot?->token) {
            $message->update(['status' => 'failed']);
            return false;
        }

        try {
            $response = Http::timeout(30)->post("https://api.telegram.org/bot{$bot->token}/sendMessage", [
                'chat_id' => $channel->channel_id,
                'text' => $message->content,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful() && $response->json('ok')) {
                $message->update([
                    'status' => 'sent',
                    'message_id' => $response->json('result.message_id'),
                    'sent_at' => now(),
                ]);
                return true;
            }
        } catch (\Exception $e) {
            report($e);
        }

        $message->update(['status' => 'failed']);
        return false;
    }
}
