<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Canal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('telegram.channels.update', $channel) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nome do Canal')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $channel->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="channel_id" :value="__('ID do Canal')" />
                            <x-text-input id="channel_id" class="block mt-1 w-full" type="text" name="channel_id" :value="old('channel_id', $channel->channel_id)" required />
                            <x-input-error :messages="$errors->get('channel_id')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="telegram_bot_id" :value="__('Bot Associado')" />
                            <select id="telegram_bot_id" name="telegram_bot_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">Selecione um bot</option>
                                @foreach($bots as $bot)
                                    <option value="{{ $bot->id }}" {{ old('telegram_bot_id', $channel->telegram_bot_id) == $bot->id ? 'selected' : '' }}>{{ $bot->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('telegram_bot_id')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="username" :value="__('Username do Canal (opcional)')" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username', $channel->username)" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Descrição (opcional)')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('description', $channel->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ $channel->is_active ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Canal Ativo</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('telegram.channels.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <x-primary-button>
                                {{ __('Atualizar Canal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
