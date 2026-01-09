<?php

namespace App\Http\Requests;

use App\Models\TelegramChannel;
use Illuminate\Foundation\Http\FormRequest;

class StoreTelegramMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        $channel = TelegramChannel::find($this->telegram_channel_id);
        return $channel && $channel->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'telegram_channel_id' => ['required', 'exists:telegram_channels,id'],
            'content' => ['required', 'string', 'max:4096'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.max' => 'O conteúdo da mensagem não pode exceder 4096 caracteres (limite do Telegram).',
            'scheduled_at.after' => 'A data de agendamento deve ser no futuro.',
        ];
    }
}
