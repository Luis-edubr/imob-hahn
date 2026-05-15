<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $module['title'] }}
            </h2>

            <a href="{{ route($module['create_route']) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Novo {{ $module['singular'] }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($properties->isEmpty())
                        <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center">
                            <p class="text-sm text-gray-500">Nenhum registro encontrado.</p>
                            <a
                                href="{{ route($module['create_route']) }}"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Criar primeiro {{ $module['singular'] }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Código</th>
                                        <th class="px-3 py-3">Título</th>
                                        <th class="px-3 py-3">Tipo</th>
                                        <th class="px-3 py-3">Negócio</th>
                                        <th class="px-3 py-3">Status</th>
                                        <th class="px-3 py-3">Cidade/UF</th>
                                        <th class="px-3 py-3">Valor</th>
                                        <th class="px-3 py-3 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach ($properties as $property)
                                        <tr>
                                            <td class="px-3 py-3 font-medium">{{ $property->code }}</td>
                                            <td class="px-3 py-3">{{ $property->title }}</td>
                                            <td class="px-3 py-3">{{ $property->property_type_label }}</td>
                                            <td class="px-3 py-3">{{ $property->transaction_label }}</td>
                                            <td class="px-3 py-3">{{ $property->status_label }}</td>
                                            <td class="px-3 py-3">{{ trim(($property->city ?? '-') . ' / ' . ($property->state ?? '-'), ' /') }}</td>
                                            <td class="px-3 py-3">{{ $property->formatted_price }}</td>
                                            <td class="px-3 py-3">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route($module['show_route'], $property) }}" class="inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200">
                                                        Ver
                                                    </a>

                                                    <a href="{{ route($module['edit_route'], $property) }}" class="inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                        Editar
                                                    </a>

                                                    <form method="POST" action="{{ route($module['destroy_route'], $property) }}" onsubmit="return confirm('Tem certeza que deseja remover este registro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                </div>
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
