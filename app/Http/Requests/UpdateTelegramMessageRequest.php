<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTelegramMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('message'));
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
