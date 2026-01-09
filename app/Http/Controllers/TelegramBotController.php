<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramBotRequest;
use App\Http\Requests\UpdateTelegramBotRequest;
use App\Models\TelegramBot;
use Illuminate\Support\Facades\Http;

class TelegramBotController extends Controller
{
    public function index()
    {
        $bots = TelegramBot::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('telegram.bots.index', compact('bots'));
    }

    public function create()
    {
        return view('telegram.bots.create');
    }

    public function store(StoreTelegramBotRequest $request)
    {
        $validated = $request->validated();

        $botInfo = $this->getBotInfo($validated['token']);
        
        if (!$botInfo) {
            return back()->withErrors(['token' => 'Token inválido. Verifique o token do bot.'])->withInput();
        }

        TelegramBot::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'username' => $botInfo['username'] ?? null,
            'token' => $validated['token'],
            'is_active' => true,
        ]);

        return redirect()->route('telegram.bots.index')
            ->with('success', 'Bot adicionado com sucesso!');
    }

    public function show(TelegramBot $bot)
    {
        $this->authorize('view', $bot);
        return view('telegram.bots.show', compact('bot'));
    }

    public function edit(TelegramBot $bot)
    {
        $this->authorize('update', $bot);
        return view('telegram.bots.edit', compact('bot'));
    }

    public function update(UpdateTelegramBotRequest $request, TelegramBot $bot)
    {
        $bot->update($request->validated());

        return redirect()->route('telegram.bots.index')
            ->with('success', 'Bot atualizado com sucesso!');
    }

    public function destroy(TelegramBot $bot)
    {
        $this->authorize('delete', $bot);
        $bot->delete();

        return redirect()->route('telegram.bots.index')
            ->with('success', 'Bot removido com sucesso!');
    }

    private function getBotInfo(string $token): ?array
    {
        try {
            $response = Http::timeout(10)->get("https://api.telegram.org/bot{$token}/getMe");
            if ($response->successful() && $response->json('ok')) {
                return $response->json('result');
            }
        } catch (\Exception $e) {
            report($e);
        }
        return null;
    }
}
