<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display the search/browse page with property listings.
     */
    public function index(Request $request)
    {
        $properties = Property::query()
            ->published()
            ->with('images')
            ->when($request->filled('transaction_type'), fn ($query) => $query->where('transaction_type', (string) $request->input('transaction_type')))
            ->when($request->filled('property_type'), fn ($query) => $query->where('property_type', (string) $request->input('property_type')))
            ->when($request->filled('city'), fn ($query) => $query->where('city', (string) $request->input('city')))
            ->when($request->filled('district'), fn ($query) => $query->where('district', (string) $request->input('district')))
            ->when($request->filled('code'), fn ($query) => $query->where('code', (string) $request->input('code')))
            ->latest('published_at')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('search', [
            'properties' => $properties,
        ]);
    }
}
