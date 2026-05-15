<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->withCount('images')
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('admin.gallery.index', [
            'properties' => $properties,
        ]);
    }

    public function show(Property $property): View
    {
        $property->load(['images.mediaAsset']);

        return view('admin.gallery.show', [
            'property' => $property,
        ]);
    }
}
