<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTelegramBotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255', 'regex:/^\d+:[A-Za-z0-9_-]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.regex' => 'O formato do token é inválido. Use o token fornecido pelo BotFather.',
        ];
    }
}
