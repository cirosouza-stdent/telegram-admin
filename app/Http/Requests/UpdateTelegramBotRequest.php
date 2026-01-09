<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTelegramBotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('bot'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255', 'regex:/^\d+:[A-Za-z0-9_-]+$/'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.regex' => 'O formato do token é inválido. Use o token fornecido pelo BotFather.',
        ];
    }
}
