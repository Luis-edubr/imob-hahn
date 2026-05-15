<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $property->title }}
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route($module['edit_route'], $property) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                    Editar
                </a>
                <a href="{{ route($module['index_route']) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                        <div><span class="font-semibold">Código:</span> {{ $property->code }}</div>
                        <div><span class="font-semibold">Tipo:</span> {{ $property->property_type_label }}</div>
                        <div><span class="font-semibold">Negócio:</span> {{ $property->transaction_label }}</div>
                        <div><span class="font-semibold">Status:</span> {{ $property->status_label }}</div>
                        <div><span class="font-semibold">Valor:</span> {{ $property->formatted_price }}</div>
                        <div><span class="font-semibold">Venda:</span> {{ $property->formatted_sale_price }}</div>
                        <div><span class="font-semibold">Aluguel:</span> {{ $property->formatted_rent_price }}</div>
                        <div><span class="font-semibold">Cidade/UF:</span> {{ $property->city }}{{ $property->state ? ' / ' . $property->state : '' }}</div>
                    </div>

                    @if ($property->short_description)
                        <div>
                            <h3 class="font-semibold mb-1">Resumo</h3>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $property->short_description }}</p>
                        </div>
                    @endif

                    @if ($property->description)
                        <div>
                            <h3 class="font-semibold mb-1">Descrição</h3>
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $property->description }}</p>
                        </div>
                    @endif

                    <div>
                        <h3 class="font-semibold mb-2">Características</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                            <div>Dormitórios: {{ $property->bedrooms ?? '-' }}</div>
                            <div>Suítes: {{ $property->suites ?? '-' }}</div>
                            <div>Banheiros: {{ $property->bathrooms ?? '-' }}</div>
                            <div>Lavabos: {{ $property->half_bathrooms ?? '-' }}</div>
                            <div>Salas: {{ $property->rooms ?? '-' }}</div>
                            <div>Garagens: {{ $property->garages ?? '-' }}</div>
                            <div>Vagas: {{ $property->parking_spaces ?? '-' }}</div>
                            <div>Pavimentos: {{ $property->floors ?? '-' }}</div>
                            <div>Área total: {{ $property->total_area ?? '-' }}</div>
                            <div>Área construída: {{ $property->built_area ?? '-' }}</div>
                            <div>Área terreno: {{ $property->land_area ?? '-' }}</div>
                            <div>Mobiliado: {{ $property->furnished ? 'Sim' : 'Não' }}</div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-2">Localização</h3>
                        <p class="text-sm">{{ $property->display_location ?: 'Não informado' }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-2">Comodidades</h3>
                        @if ($property->amenities->isEmpty())
                            <p class="text-sm text-gray-500">Nenhuma comodidade vinculada.</p>
                        @else
                            <div class="flex flex-wrap gap-2">
                                @foreach ($property->amenities as $amenity)
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">{{ $amenity->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-semibold mb-2">Galeria</h3>
                        @if ($property->images->isEmpty())
                            <p class="text-sm text-gray-500">Nenhuma imagem cadastrada.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($property->images as $image)
                                    <div class="rounded-lg border border-gray-200 overflow-hidden">
                                        <img src="{{ $image->url ?? 'https://placehold.co/600x400?text=Imagem' }}" alt="{{ $image->alt_text ?: $property->title }}" class="w-full h-40 object-cover">
                                        <div class="p-3 text-xs text-gray-600">
                                            <p><span class="font-semibold">Ordem:</span> {{ $image->sort_order }}</p>
                                            <p><span class="font-semibold">Capa:</span> {{ $image->is_cover ? 'Sim' : 'Não' }}</p>
                                            @if ($image->alt_text)
                                                <p><span class="font-semibold">Alt:</span> {{ $image->alt_text }}</p>
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
    </div>
</x-app-layout>
