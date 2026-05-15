<?php

namespace Tests\Feature\Admin;

use App\Models\MediaAsset;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyMediaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_property_with_uploaded_image(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.properties.store'), [
            'code' => 'IMV-1001',
            'title' => 'Casa com Piscina',
            'property_type' => 'casa',
            'transaction_type' => 'sale',
            'status' => 'published',
            'active' => '1',
            'images' => [
                [
                    'alt_text' => 'Fachada principal',
                    'sort_order' => '0',
                    'is_cover' => '1',
                    'file' => UploadedFile::fake()->image('fachada.jpg', 3200, 2200),
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.properties.index'));

        $this->assertDatabaseHas('properties', ['code' => 'IMV-1001']);
        $this->assertDatabaseCount('media_assets', 1);
        $this->assertDatabaseCount('property_images', 1);

        $asset = MediaAsset::query()->firstOrFail();

        Storage::disk('local')->assertExists($asset->path);

        $this->assertSame('image/webp', $asset->mime);
        $this->assertNotNull($asset->width);
        $this->assertNotNull($asset->height);
        $this->assertLessThanOrEqual(2560, $asset->width);
        $this->assertLessThanOrEqual(2560, $asset->height);

        $propertyImage = PropertyImage::query()->firstOrFail();

        $this->assertSame($asset->id, $propertyImage->media_asset_id);
        $this->assertTrue($propertyImage->is_cover);
    }

    public function test_admin_can_reuse_existing_library_image_on_property_update(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        $property = Property::query()->create([
            'code' => 'IMV-1002',
            'slug' => 'imv-1002',
            'title' => 'Apartamento Central',
            'property_type' => 'apartamento',
            'transaction_type' => 'sale',
            'status' => 'draft',
            'active' => true,
        ]);

        Storage::disk('local')->put('media/2026/05/existente.webp', 'fake-image-content');

        $mediaAsset = MediaAsset::query()->create([
            'disk' => 'local',
            'path' => 'media/2026/05/existente.webp',
            'mime' => 'image/webp',
            'size_bytes' => strlen('fake-image-content'),
            'width' => 1200,
            'height' => 900,
            'original_name' => 'existente.webp',
            'checksum' => hash('sha256', 'fake-image-content'),
        ]);

        $response = $this->actingAs($user)->put(route('admin.properties.update', $property), [
            'code' => 'IMV-1002',
            'title' => 'Apartamento Central Atualizado',
            'property_type' => 'apartamento',
            'transaction_type' => 'sale',
            'status' => 'published',
            'active' => '1',
            'images' => [
                [
                    'media_asset_id' => (string) $mediaAsset->id,
                    'alt_text' => 'Imagem reutilizada',
                    'sort_order' => '0',
                    'is_cover' => '1',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.properties.index'));

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Apartamento Central Atualizado',
        ]);

        $this->assertDatabaseHas('property_images', [
            'property_id' => $property->id,
            'media_asset_id' => $mediaAsset->id,
            'is_cover' => true,
        ]);
    }
}
