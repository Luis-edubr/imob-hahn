<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Galeria - {{ $property->title }}
            </h2>

            <a href="{{ route('admin.gallery.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Voltar para galeria
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-sm text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div><span class="font-semibold">Código:</span> {{ $property->code }}</div>
                        <div><span class="font-semibold">Tipo:</span> {{ $property->property_type_label }}</div>
                        <div><span class="font-semibold">Status:</span> {{ $property->status_label }}</div>
                        <div><span class="font-semibold">Total:</span> {{ $property->images->count() }} imagem(ns)</div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($property->images->isEmpty())
                        <p class="text-sm text-gray-500">Nenhuma imagem vinculada a este registro.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($property->images as $image)
                                <div class="rounded-lg border border-gray-200 overflow-hidden bg-white">
                                    <img src="{{ $image->url ?? 'https://placehold.co/600x400?text=Imagem' }}" alt="{{ $image->alt_text ?: $property->title }}" class="w-full h-40 object-cover">
                                    <div class="p-3 text-xs text-gray-700 space-y-1">
                                        <p><span class="font-semibold">Ordem:</span> {{ $image->sort_order }}</p>
                                        <p><span class="font-semibold">Capa:</span> {{ $image->is_cover ? 'Sim' : 'Não' }}</p>
                                        @if ($image->alt_text)
                                            <p><span class="font-semibold">Alt:</span> {{ $image->alt_text }}</p>
                                        @endif
                                        @if ($image->download_url)
                                            <a href="{{ $image->download_url }}" class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
