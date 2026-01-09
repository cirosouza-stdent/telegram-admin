<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adicionar Bot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('telegram.bots.store') }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nome do Bot')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Meu Bot Telegram" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="token" :value="__('Token do Bot')" />
                            <x-text-input id="token" class="block mt-1 w-full" type="text" name="token" :value="old('token')" required placeholder="123456789:ABCdefGHIjklMNOpqrsTUVwxyz" />
                            <x-input-error :messages="$errors->get('token')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Obtenha o token criando um bot com o <a href="https://t.me/BotFather" target="_blank" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">@BotFather</a>
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('telegram.bots.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancelar</a>
                            <x-primary-button>
                                {{ __('Salvar Bot') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
