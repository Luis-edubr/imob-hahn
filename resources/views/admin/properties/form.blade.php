@php
    $isEdit = $property->exists;
    $action = $isEdit ? route($module['update_route'], $property) : route($module['store_route']);
    $mediaAssetsById = $mediaAssets->keyBy('id');

    $moneyValue = function (string $field) use ($property) {
        $oldValue = old($field);

        if ($oldValue !== null) {
            return $oldValue;
        }

        $amount = $property->{$field};

        return $amount !== null ? (string) ((int) round($amount / 100)) : '';
    };

    $imageRows = old('images');

    if ($imageRows === null) {
        $imageRows = $property->images->map(fn ($image) => [
            'media_asset_id' => $image->media_asset_id,
            'alt_text' => $image->alt_text,
            'sort_order' => $image->sort_order,
            'is_cover' => (bool) $image->is_cover,
        ])->values()->all();
    }

    if (empty($imageRows)) {
        $imageRows = [['media_asset_id' => null, 'alt_text' => '', 'sort_order' => 0, 'is_cover' => false]];
    }

    $selectedAmenities = collect(old('amenity_ids', $property->amenities->pluck('id')->all()))
        ->map(fn ($id) => (int) $id)
        ->all();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $isEdit ? 'Editar ' . $module['singular'] : 'Novo ' . $module['singular'] }}
            </h2>

            <a href="{{ route($module['index_route']) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Voltar para {{ strtolower($module['title']) }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                            <p class="font-semibold">Confira os campos abaixo:</p>
                            <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="code">Código</label>
                                <input id="code" name="code" type="text" value="{{ old('code', $property->code) }}" class="w-full rounded-md border-gray-300" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1" for="title">Título</label>
                                <input id="title" name="title" type="text" value="{{ old('title', $property->title) }}" class="w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" for="slug">Slug</label>
                                <input id="slug" name="slug" type="text" value="{{ old('slug', $property->slug) }}" class="w-full rounded-md border-gray-300" placeholder="gerado automaticamente">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="property_type">Tipo</label>
                                <select id="property_type" name="property_type" class="w-full rounded-md border-gray-300" {{ $module['is_land'] ? 'disabled' : '' }}>
                                    @foreach ($typeOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('property_type', $property->property_type) === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if ($module['is_land'])
                                    <input type="hidden" name="property_type" value="terreno">
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="transaction_type">Negócio</label>
                                <select id="transaction_type" name="transaction_type" class="w-full rounded-md border-gray-300" required>
                                    @foreach ($transactionOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('transaction_type', $property->transaction_type) === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="status">Status</label>
                                <select id="status" name="status" class="w-full rounded-md border-gray-300" required>
                                    @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('status', $property->status ?? 'draft') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1" for="published_at">Data de publicação</label>
                                <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $property->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-md border-gray-300">
                            </div>

                            <div class="md:col-span-4">
                                <label class="block text-sm font-medium mb-1" for="short_description">Resumo</label>
                                <input id="short_description" name="short_description" type="text" value="{{ old('short_description', $property->short_description) }}" class="w-full rounded-md border-gray-300">
                            </div>

                            <div class="md:col-span-4">
                                <label class="block text-sm font-medium mb-1" for="description">Descrição</label>
                                <textarea id="description" name="description" rows="5" class="w-full rounded-md border-gray-300">{{ old('description', $property->description) }}</textarea>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold mb-3">Valores</h3>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="price">Preço principal</label>
                                    <input id="price" name="price" type="text" value="{{ $moneyValue('price') }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric" placeholder="Ex: 500000">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="price_sale">Valor de venda</label>
                                    <input id="price_sale" name="price_sale" type="text" value="{{ $moneyValue('price_sale') }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric" placeholder="Ex: 500000">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="price_rent">Valor de aluguel</label>
                                    <input id="price_rent" name="price_rent" type="text" value="{{ $moneyValue('price_rent') }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric" placeholder="Ex: 1800">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="condo_fee">Condomínio</label>
                                    <input id="condo_fee" name="condo_fee" type="text" value="{{ $moneyValue('condo_fee') }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric" placeholder="Ex: 350">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="iptu_value">IPTU</label>
                                    <input id="iptu_value" name="iptu_value" type="text" value="{{ $moneyValue('iptu_value') }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric" placeholder="Ex: 1200">
                                </div>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold mb-3">Características</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div><label class="block text-sm font-medium mb-1" for="total_area">Área total (m²)</label><input id="total_area" name="total_area" type="text" value="{{ old('total_area', $property->total_area) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="built_area">Área construída (m²)</label><input id="built_area" name="built_area" type="text" value="{{ old('built_area', $property->built_area) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="land_area">Área do terreno (m²)</label><input id="land_area" name="land_area" type="text" value="{{ old('land_area', $property->land_area) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="floors">Pavimentos</label><input id="floors" name="floors" type="text" value="{{ old('floors', $property->floors) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>

                                <div><label class="block text-sm font-medium mb-1" for="bedrooms">Dormitórios</label><input id="bedrooms" name="bedrooms" type="text" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="suites">Suítes</label><input id="suites" name="suites" type="text" value="{{ old('suites', $property->suites) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="bathrooms">Banheiros</label><input id="bathrooms" name="bathrooms" type="text" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="half_bathrooms">Lavabos</label><input id="half_bathrooms" name="half_bathrooms" type="text" value="{{ old('half_bathrooms', $property->half_bathrooms) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>

                                <div><label class="block text-sm font-medium mb-1" for="rooms">Salas</label><input id="rooms" name="rooms" type="text" value="{{ old('rooms', $property->rooms) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="garages">Garagens</label><input id="garages" name="garages" type="text" value="{{ old('garages', $property->garages) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="parking_spaces">Vagas</label><input id="parking_spaces" name="parking_spaces" type="text" value="{{ old('parking_spaces', $property->parking_spaces) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="furnished" value="1" @checked(old('furnished', $property->furnished))> Mobiliado</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="featured" value="1" @checked(old('featured', $property->featured))> Destaque</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="highlight_home" value="1" @checked(old('highlight_home', $property->highlight_home))> Exibir na Home</label>
                                <label class="inline-flex items-center gap-2"><input type="checkbox" name="active" value="1" @checked(old('active', $property->active ?? true))> Ativo</label>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold mb-3">Localização</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div><label class="block text-sm font-medium mb-1" for="postal_code">CEP</label><input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $property->postal_code) }}" class="w-full rounded-md border-gray-300"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-1" for="street">Rua</label><input id="street" name="street" type="text" value="{{ old('street', $property->street) }}" class="w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium mb-1" for="number">Número</label><input id="number" name="number" type="text" value="{{ old('number', $property->number) }}" class="w-full rounded-md border-gray-300"></div>

                                <div><label class="block text-sm font-medium mb-1" for="complement">Complemento</label><input id="complement" name="complement" type="text" value="{{ old('complement', $property->complement) }}" class="w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium mb-1" for="district">Bairro</label><input id="district" name="district" type="text" value="{{ old('district', $property->district) }}" class="w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium mb-1" for="city">Cidade</label><input id="city" name="city" type="text" value="{{ old('city', $property->city) }}" class="w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium mb-1" for="state">UF</label><input id="state" name="state" type="text" maxlength="2" value="{{ old('state', $property->state) }}" class="w-full rounded-md border-gray-300"></div>

                                <div><label class="block text-sm font-medium mb-1" for="country">País</label><input id="country" name="country" type="text" value="{{ old('country', $property->country ?? 'Brasil') }}" class="w-full rounded-md border-gray-300"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-1" for="location_label">Rótulo de localização</label><input id="location_label" name="location_label" type="text" value="{{ old('location_label', $property->location_label) }}" class="w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium mb-1" for="maps_url">Link do mapa</label><input id="maps_url" name="maps_url" type="url" value="{{ old('maps_url', $property->maps_url) }}" class="w-full rounded-md border-gray-300"></div>

                                <div><label class="block text-sm font-medium mb-1" for="latitude">Latitude</label><input id="latitude" name="latitude" type="text" value="{{ old('latitude', $property->latitude) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                                <div><label class="block text-sm font-medium mb-1" for="longitude">Longitude</label><input id="longitude" name="longitude" type="text" value="{{ old('longitude', $property->longitude) }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric"></div>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold mb-3">Mídia</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-sm font-medium mb-1" for="video_url">URL do vídeo</label><input id="video_url" name="video_url" type="url" value="{{ old('video_url', $property->video_url) }}" class="w-full rounded-md border-gray-300"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium mb-1" for="virtual_tour_url">URL do tour virtual</label><input id="virtual_tour_url" name="virtual_tour_url" type="url" value="{{ old('virtual_tour_url', $property->virtual_tour_url) }}" class="w-full rounded-md border-gray-300"></div>
                            </div>

                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold">Galeria de imagens</h4>
                                    <button type="button" id="add-image-row" class="inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100">Adicionar imagem</button>
                                </div>
                                <p class="mb-3 text-xs text-gray-500">Selecione exatamente uma imagem como capa.</p>
                                <p class="mb-3 text-xs text-gray-500">Cada linha deve usar uma imagem da biblioteca OU upload de novo arquivo (jpg, png, webp, avif - até 10MB).</p>

                                <div id="images-rows" class="space-y-3">
                                    @foreach ($imageRows as $index => $image)
                                        @php
                                            $selectedMediaAsset = !empty($image['media_asset_id']) ? $mediaAssetsById->get((int) $image['media_asset_id']) : null;
                                        @endphp
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 image-row rounded-md border border-gray-200 p-3">
                                            <div class="md:col-span-4">
                                                <label class="block text-xs font-medium mb-1">Biblioteca</label>
                                                <select name="images[{{ $index }}][media_asset_id]" class="w-full rounded-md border-gray-300 js-media-select">
                                                    <option value="">Selecionar imagem existente</option>
                                                    @foreach ($mediaAssets as $mediaAsset)
                                                        <option value="{{ $mediaAsset->id }}" @selected((string) ($image['media_asset_id'] ?? '') === (string) $mediaAsset->id)>
                                                            #{{ $mediaAsset->id }} - {{ \Illuminate\Support\Str::limit($mediaAsset->original_name, 40) }} ({{ $mediaAsset->width }}x{{ $mediaAsset->height }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="md:col-span-3">
                                                <label class="block text-xs font-medium mb-1">Upload</label>
                                                <input type="file" name="images[{{ $index }}][file]" accept=".jpg,.jpeg,.png,.webp,.avif,image/jpeg,image/png,image/webp,image/avif" class="w-full rounded-md border-gray-300 js-upload-input">
                                            </div>

                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-medium mb-1">Descrição</label>
                                                <input type="text" name="images[{{ $index }}][alt_text]" value="{{ $image['alt_text'] ?? '' }}" class="w-full rounded-md border-gray-300" placeholder="Fachada">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-medium mb-1">Ordem</label>
                                                <input type="text" name="images[{{ $index }}][sort_order]" value="{{ $image['sort_order'] ?? $index }}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric">
                                            </div>
                                            <div class="md:col-span-1 flex items-end">
                                                <label class="inline-flex items-center gap-2 text-xs"><input type="checkbox" class="js-cover-checkbox" name="images[{{ $index }}][is_cover]" value="1" @checked(!empty($image['is_cover']))> Capa</label>
                                            </div>
                                            <div class="md:col-span-1 flex items-end justify-end">
                                                <button type="button" class="remove-image-row inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100">Remover</button>
                                            </div>

                                            @if ($selectedMediaAsset)
                                                <div class="md:col-span-12">
                                                    <img src="{{ $selectedMediaAsset->url }}" alt="{{ $selectedMediaAsset->original_name }}" class="h-16 rounded border border-gray-200">
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-semibold mb-3">Comodidades</h3>
                            @if ($amenities->isEmpty())
                                <p class="text-sm text-gray-500">Nenhuma comodidade cadastrada.</p>
                            @else
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                                    @foreach ($amenities as $amenity)
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" @checked(in_array($amenity->id, $selectedAmenities, true))>
                                            <span>{{ $amenity->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </section>

                        <div class="pt-4 border-t border-gray-200 flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ $isEdit ? 'Atualizar' : 'Cadastrar' }} {{ $module['singular'] }}
                            </button>

                            <a href="{{ route($module['index_route']) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const rowsContainer = document.getElementById('images-rows');
            const addButton = document.getElementById('add-image-row');
            const mediaSelectTemplate = rowsContainer.querySelector('.js-media-select')?.innerHTML
                ?? '<option value=\"\">Selecionar imagem existente</option>';

            if (!rowsContainer || !addButton) {
                return;
            }

            const enforceDigitsOnly = (input) => {
                input.value = input.value.replace(/\D/g, '');
            };

            const bindDigitsOnlyInputs = (scope = document) => {
                scope.querySelectorAll('.js-only-digits').forEach((input) => {
                    if (input.dataset.digitsBound === '1') {
                        return;
                    }

                    input.dataset.digitsBound = '1';
                    input.addEventListener('input', () => enforceDigitsOnly(input));
                    input.addEventListener('paste', () => {
                        setTimeout(() => enforceDigitsOnly(input), 0);
                    });
                });
            };

            const syncCoverSelection = () => {
                const coverCheckboxes = rowsContainer.querySelectorAll('.js-cover-checkbox');
                const checked = Array.from(coverCheckboxes).filter((checkbox) => checkbox.checked);

                if (checked.length <= 1) {
                    return;
                }

                checked.slice(1).forEach((checkbox) => {
                    checkbox.checked = false;
                });
            };

            const getNextIndex = () => rowsContainer.querySelectorAll('.image-row').length;

            addButton.addEventListener('click', function () {
                const index = getNextIndex();
                const row = document.createElement('div');
                row.className = 'grid grid-cols-1 md:grid-cols-12 gap-3 image-row rounded-md border border-gray-200 p-3';

                row.innerHTML = `
                    <div class="md:col-span-4">
                        <label class="block text-xs font-medium mb-1">Biblioteca</label>
                        <select name="images[${index}][media_asset_id]" class="w-full rounded-md border-gray-300 js-media-select">
                            ${mediaSelectTemplate}
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium mb-1">Upload</label>
                        <input type="file" name="images[${index}][file]" accept=".jpg,.jpeg,.png,.webp,.avif,image/jpeg,image/png,image/webp,image/avif" class="w-full rounded-md border-gray-300 js-upload-input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium mb-1">Descrição</label>
                        <input type="text" name="images[${index}][alt_text]" class="w-full rounded-md border-gray-300" placeholder="Fachada">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium mb-1">Ordem</label>
                        <input type="text" name="images[${index}][sort_order]" value="${index}" class="w-full rounded-md border-gray-300 js-only-digits" inputmode="numeric">
                    </div>
                    <div class="md:col-span-1 flex items-end">
                        <label class="inline-flex items-center gap-2 text-xs"><input type="checkbox" class="js-cover-checkbox" name="images[${index}][is_cover]" value="1"> Capa</label>
                    </div>
                    <div class="md:col-span-1 flex items-end justify-end">
                        <button type="button" class="remove-image-row inline-flex items-center px-3 py-2 rounded-md text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100">Remover</button>
                    </div>
                `;

                rowsContainer.appendChild(row);
                bindDigitsOnlyInputs(row);
                syncCoverSelection();
            });

            rowsContainer.addEventListener('click', function (event) {
                if (!event.target.classList.contains('remove-image-row')) {
                    return;
                }

                const row = event.target.closest('.image-row');

                if (!row) {
                    return;
                }

                row.remove();
            });

            rowsContainer.addEventListener('change', function (event) {
                if (!event.target.classList.contains('js-cover-checkbox')) {
                    if (event.target.classList.contains('js-media-select')) {
                        const row = event.target.closest('.image-row');
                        const uploadInput = row?.querySelector('.js-upload-input');

                        if (event.target.value && uploadInput) {
                            uploadInput.value = '';
                        }
                    }

                    if (event.target.classList.contains('js-upload-input')) {
                        const row = event.target.closest('.image-row');
                        const mediaSelect = row?.querySelector('.js-media-select');

                        if (event.target.files?.length && mediaSelect) {
                            mediaSelect.value = '';
                        }
                    }

                    return;
                }

                if (event.target.checked) {
                    rowsContainer.querySelectorAll('.js-cover-checkbox').forEach((checkbox) => {
                        if (checkbox !== event.target) {
                            checkbox.checked = false;
                        }
                    });
                }

                syncCoverSelection();
            });

            bindDigitsOnlyInputs(document);
            syncCoverSelection();
        })();
    </script>
</x-app-layout>
