<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nova Mensagem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($channels->count() == 0)
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nenhum canal disponível</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Você precisa cadastrar um canal antes de enviar mensagens.</p>
                            <div class="mt-6">
                                <a href="{{ route('telegram.channels.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Adicionar Canal
                                </a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('telegram.messages.store') }}">
                            @csrf

                            <div class="mb-6">
                                <x-input-label for="telegram_channel_id" :value="__('Canal')" />
                                <select id="telegram_channel_id" name="telegram_channel_id" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    <option value="">Selecione um canal</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('telegram_channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }} ({{ $channel->bot->name ?? 'Sem bot' }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('telegram_channel_id')" class="mt-2" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="content" :value="__('Mensagem')" />
                                <textarea id="content" name="content" rows="6" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" placeholder="Digite sua mensagem aqui...">{{ old('content') }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Suporta formatação HTML: &lt;b&gt;negrito&lt;/b&gt;, &lt;i&gt;itálico&lt;/i&gt;, &lt;a href=""&gt;link&lt;/a&gt;
                                </p>
                            </div>

                            <div class="mb-6">
                                <x-input-label for="scheduled_at" :value="__('Agendar para (opcional)')" />
                                <x-text-input id="scheduled_at" class="block mt-1 w-full" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" />
                                <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Deixe em branco para enviar imediatamente
                                </p>
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('telegram.messages.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                                <x-primary-button>
                                    {{ __('Enviar Mensagem') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
