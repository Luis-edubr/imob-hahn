<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('admin.properties.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-transparent hover:border-indigo-300 transition">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Imóveis</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Cadastre e gerencie casas, apartamentos e salas comerciais.</p>
                    </div>
                </a>

                <a href="{{ route('admin.lands.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-transparent hover:border-indigo-300 transition">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Terrenos</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Gerencie terrenos com fluxo próprio dentro do CMS.</p>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-sm text-gray-700 dark:text-gray-300">
                    Área administrativa pronta para evolução dos próximos módulos em <code>/admin/modulo</code>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
