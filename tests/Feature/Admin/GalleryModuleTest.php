<?php

namespace Tests\Feature\Admin;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_gallery_index_and_property_gallery_page(): void
    {
        $user = User::factory()->create();

        $property = Property::query()->create([
            'code' => 'GAL-1',
            'slug' => 'gal-1',
            'title' => 'Imóvel da Galeria',
            'property_type' => 'casa',
            'transaction_type' => 'sale',
            'status' => 'published',
            'active' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.gallery.index'))
            ->assertOk()
            ->assertSee('Galeria')
            ->assertSee('Imóvel da Galeria');

        $this->actingAs($user)
            ->get(route('admin.gallery.show', $property))
            ->assertOk()
            ->assertSee('Imóvel da Galeria');
    }
}
