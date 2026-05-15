<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use App\Models\Amenity;
use App\Models\MediaAsset;
use App\Models\Property;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class PropertyController extends Controller
{
    public function index(): View
    {
        return $this->renderIndex(false);
    }

    public function create(): View
    {
        return $this->renderForm(new Property(), false);
    }

    public function store(PropertyRequest $request): RedirectResponse
    {
        return $this->persist($request, new Property(), false);
    }

    public function edit(Property $property): View
    {
        return $this->renderForm($property, false);
    }

    public function show(Property $property): View
    {
        return $this->renderShow($property, false);
    }

    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        return $this->persist($request, $property, false);
    }

    public function destroy(Property $property): RedirectResponse
    {
        return $this->remove($property, false);
    }

    public function landsIndex(): View
    {
        return $this->renderIndex(true);
    }

    public function landsCreate(): View
    {
        return $this->renderForm(new Property(), true);
    }

    public function landsStore(PropertyRequest $request): RedirectResponse
    {
        return $this->persist($request, new Property(), true);
    }

    public function landsEdit(Property $property): View
    {
        return $this->renderForm($property, true);
    }

    public function landsShow(Property $property): View
    {
        return $this->renderShow($property, true);
    }

    public function landsUpdate(PropertyRequest $request, Property $property): RedirectResponse
    {
        return $this->persist($request, $property, true);
    }

    public function landsDestroy(Property $property): RedirectResponse
    {
        return $this->remove($property, true);
    }

    private function renderIndex(bool $onlyLands): View
    {
        $properties = Property::query()
            ->when($onlyLands, fn ($query) => $query->where('property_type', 'terreno'))
            ->when(! $onlyLands, fn ($query) => $query->where('property_type', '!=', 'terreno'))
            ->latest()
            ->paginate(15);

        return view('admin.properties.index', [
            'properties' => $properties,
            'module' => $this->moduleMeta($onlyLands),
        ]);
    }

    private function renderForm(Property $property, bool $onlyLands): View
    {
        $this->guardModuleProperty($property, $onlyLands);

        if ($onlyLands && ! $property->exists) {
            $property->property_type = 'terreno';
        }

        $property->load(['amenities:id', 'images.mediaAsset']);

        return view('admin.properties.form', [
            'property' => $property,
            'module' => $this->moduleMeta($onlyLands),
            'amenities' => Amenity::query()->active()->orderBy('name')->get(['id', 'name']),
            'mediaAssets' => MediaAsset::query()->latest()->limit(200)->get(),
            'highlightSlots' => [
                'sale_remaining' => max(0, 4 - Property::query()->where('highlight_sale', true)->when($property->exists, fn ($query) => $query->whereKeyNot($property->id))->count()),
                'rent_remaining' => max(0, 4 - Property::query()->where('highlight_rent', true)->when($property->exists, fn ($query) => $query->whereKeyNot($property->id))->count()),
                'weekly_available' => ! Property::query()->where('weekly_deal', true)->when($property->exists, fn ($query) => $query->whereKeyNot($property->id))->exists(),
            ],
            'typeOptions' => $onlyLands
                ? ['terreno' => Property::propertyTypeOptions()['terreno']]
                : collect(Property::propertyTypeOptions())->except('terreno')->all(),
            'transactionOptions' => Property::transactionTypeOptions(),
            'statusOptions' => Property::statusOptions(),
        ]);
    }

    private function renderShow(Property $property, bool $onlyLands): View
    {
        $this->guardModuleProperty($property, $onlyLands);

        $property->load(['amenities:id,name', 'images.mediaAsset']);

        return view('admin.properties.show', [
            'property' => $property,
            'module' => $this->moduleMeta($onlyLands),
        ]);
    }

    private function persist(PropertyRequest $request, Property $property, bool $onlyLands): RedirectResponse
    {
        $this->guardModuleProperty($property, $onlyLands);

        $validated = $request->validated();
        $imageFiles = $request->file('images', []);

        $amenityIds = $validated['amenity_ids'] ?? [];
        $images = $validated['images'] ?? [];

        unset($validated['amenity_ids'], $validated['images']);

        if ($onlyLands) {
            $validated['property_type'] = 'terreno';
        }

        $imageService = app(ImageService::class);
        $imagePayloads = [];

        if (! empty($images)) {
            foreach ($images as $index => $image) {
                $isCover = (bool) ($image['is_cover'] ?? false);
                $mediaAsset = null;
                $uploadedFile = $imageFiles[$index]['file'] ?? null;

                if ($uploadedFile) {
                    $mediaAsset = $imageService->upload($uploadedFile);
                } elseif (! empty($image['media_asset_id'])) {
                    $mediaAsset = MediaAsset::query()->findOrFail((int) $image['media_asset_id']);
                }

                $imagePayloads[] = [
                    'media_asset_id' => $mediaAsset?->id,
                    'disk' => $mediaAsset?->disk ?? 'local',
                    'path' => $mediaAsset?->path ?? '',
                    'alt_text' => $image['alt_text'] ?? null,
                    'sort_order' => $image['sort_order'] ?? $index,
                    'is_cover' => $isCover,
                ];
            }
        }

        DB::transaction(function () use ($property, $validated, $amenityIds, $imagePayloads): void {
            $property->fill($validated);
            $property->save();

            $property->amenities()->sync($amenityIds);

            $property->images()->delete();

            if (! empty($imagePayloads)) {
                $property->images()->createMany($imagePayloads);
            }
        });

        $mainImage = $property->main_image;
        $property->forceFill([
            'cover_image_path' => $mainImage?->path ?? $property->cover_image_path,
            'cover_image_alt' => $mainImage?->alt_text ?? $property->cover_image_alt,
        ])->save();

        $module = $this->moduleMeta($onlyLands);

        return redirect()
            ->route($module['index_route'])
            ->with('status', $property->wasRecentlyCreated
                ? $module['singular'] . ' cadastrado com sucesso.'
                : $module['singular'] . ' atualizado com sucesso.');
    }

    private function remove(Property $property, bool $onlyLands): RedirectResponse
    {
        $this->guardModuleProperty($property, $onlyLands);

        $property->delete();

        $module = $this->moduleMeta($onlyLands);

        return redirect()
            ->route($module['index_route'])
            ->with('status', $module['singular'] . ' removido com sucesso.');
    }

    private function guardModuleProperty(Property $property, bool $onlyLands): void
    {
        if (! $property->exists) {
            return;
        }

        if ($onlyLands && $property->property_type !== 'terreno') {
            abort(404);
        }

        if (! $onlyLands && $property->property_type === 'terreno') {
            abort(404);
        }
    }

    private function moduleMeta(bool $onlyLands): array
    {
        if ($onlyLands) {
            return [
                'title' => 'Terrenos',
                'singular' => 'Terreno',
                'index_route' => 'admin.lands.index',
                'create_route' => 'admin.lands.create',
                'store_route' => 'admin.lands.store',
                'edit_route' => 'admin.lands.edit',
                'show_route' => 'admin.lands.show',
                'update_route' => 'admin.lands.update',
                'destroy_route' => 'admin.lands.destroy',
                'is_land' => true,
            ];
        }

        return [
            'title' => 'Imóveis',
            'singular' => 'Imóvel',
            'index_route' => 'admin.properties.index',
            'create_route' => 'admin.properties.create',
            'store_route' => 'admin.properties.store',
            'edit_route' => 'admin.properties.edit',
            'show_route' => 'admin.properties.show',
            'update_route' => 'admin.properties.update',
            'destroy_route' => 'admin.properties.destroy',
            'is_land' => false,
        ];
    }
}
