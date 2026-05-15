<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Galeria
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($properties->isEmpty())
                        <p class="text-sm text-gray-500">Nenhum imóvel ou terreno encontrado.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Código</th>
                                        <th class="px-3 py-3">Título</th>
                                        <th class="px-3 py-3">Tipo</th>
                                        <th class="px-3 py-3">Qtd. imagens</th>
                                        <th class="px-3 py-3 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach ($properties as $property)
                                        <tr>
                                            <td class="px-3 py-3 font-medium">{{ $property->code }}</td>
                                            <td class="px-3 py-3">{{ $property->title }}</td>
                                            <td class="px-3 py-3">{{ $property->property_type_label }}</td>
                                            <td class="px-3 py-3">{{ $property->images_count }}</td>
                                            <td class="px-3 py-3 text-right">
                                                <a href="{{ route('admin.gallery.show', $property) }}" class="inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                    Ver galeria
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
