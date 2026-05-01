<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display the search/browse page with property listings.
     */
    public function index()
    {
        // Hardcoded sample properties for display
        $properties = [
            ['id' => 1, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 2, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 3, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 4, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 5, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 6, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 7, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 8, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 9, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 10, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 11, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
            ['id' => 12, 'title' => 'INDUSTRIAL I - BAGÉ', 'address' => 'Rua Doutor Pena', 'bedrooms' => 2, 'bathrooms' => 1, 'garages' => 1, 'code' => 2842],
        ];

        $currentPage = request('page', 1);
        $totalCount = 23;
        $itemsPerPage = 12;
        $totalPages = ceil($totalCount / $itemsPerPage);

        return view('search', [
            'properties' => $properties,
            'currentPage' => $currentPage,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages,
        ]);
    }
}
