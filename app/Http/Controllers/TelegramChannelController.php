<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramChannelRequest;
use App\Http\Requests\UpdateTelegramChannelRequest;
use App\Models\TelegramBot;
use App\Models\TelegramChannel;

class TelegramChannelController extends Controller
{
    public function index()
    {
        $channels = TelegramChannel::where('user_id', auth()->id())
            ->with('bot:id,name,username')
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('telegram.channels.index', compact('channels'));
    }

    public function create()
    {
        $bots = TelegramBot::where('user_id', auth()->id())
            ->where('is_active', true)
            ->select('id', 'name', 'username')
            ->get();
        return view('telegram.channels.create', compact('bots'));
    }

    public function store(StoreTelegramChannelRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['is_active'] = true;

        TelegramChannel::create($validated);

        return redirect()->route('telegram.channels.index')
            ->with('success', 'Canal adicionado com sucesso!');
    }

    public function show(TelegramChannel $channel)
    {
        $this->authorize('view', $channel);
        $channel->load(['bot:id,name,username', 'messages' => fn($q) => $q->latest()->limit(10)]);
        return view('telegram.channels.show', compact('channel'));
    }

    public function edit(TelegramChannel $channel)
    {
        $this->authorize('update', $channel);
        $bots = TelegramBot::where('user_id', auth()->id())
            ->where('is_active', true)
            ->select('id', 'name', 'username')
            ->get();
        return view('telegram.channels.edit', compact('channel', 'bots'));
    }

    public function update(UpdateTelegramChannelRequest $request, TelegramChannel $channel)
    {
        $channel->update($request->validated());

        return redirect()->route('telegram.channels.index')
            ->with('success', 'Canal atualizado com sucesso!');
    }

    public function destroy(TelegramChannel $channel)
    {
        $this->authorize('delete', $channel);
        $channel->delete();

        return redirect()->route('telegram.channels.index')
            ->with('success', 'Canal removido com sucesso!');
    }
}
