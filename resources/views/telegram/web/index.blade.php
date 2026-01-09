<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                {{ __('Telegram Web') }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="https://web.telegram.org" target="_blank" class="inline-flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Abrir em nova aba
                </a>
                <button onclick="reloadTelegram()" class="inline-flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Recarregar
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Info Banner -->
            <div class="mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="ml-3 text-sm text-blue-700 dark:text-blue-300">
                        Acesse o Telegram Web diretamente do painel. Faça login com seu número de telefone para gerenciar seus canais e grupos.
                    </p>
                </div>
            </div>

            <!-- Telegram Web Container -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative" style="height: calc(100vh - 250px); min-height: 600px;">
                    <!-- Loading Overlay -->
                    <div id="telegram-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-700 z-10">
                        <div class="text-center">
                            <svg class="animate-spin h-12 w-12 text-blue-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">Carregando Telegram Web...</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Isso pode levar alguns segundos</p>
                        </div>
                    </div>
                    
                    <!-- Telegram Web iFrame -->
                    <iframe 
                        id="telegram-frame"
                        src="https://web.telegram.org/k/" 
                        class="w-full h-full border-0 rounded-lg"
                        allow="clipboard-read; clipboard-write; microphone; camera"
                        sandbox="allow-scripts allow-same-origin allow-popups allow-forms allow-modals allow-downloads"
                        loading="lazy"
                        onload="hideTelegramLoading()"
                    ></iframe>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <h4 class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100">Login Seguro</h4>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Use seu número de telefone para fazer login de forma segura no Telegram.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </span>
                        <h4 class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100">Gerenciar Canais</h4>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gerencie seus canais e grupos diretamente pela interface do Telegram.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 dark:bg-purple-900">
                            <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </span>
                        <h4 class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100">Notificações</h4>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Receba notificações em tempo real das suas conversas.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hideTelegramLoading() {
            setTimeout(() => {
                document.getElementById('telegram-loading').style.display = 'none';
            }, 1000);
        }

        function reloadTelegram() {
            document.getElementById('telegram-loading').style.display = 'flex';
            document.getElementById('telegram-frame').src = document.getElementById('telegram-frame').src;
        }
    </script>
</x-app-layout>
