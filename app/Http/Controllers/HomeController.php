<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $saleHighlights = Property::query()
            ->published()
            ->forSale()
            ->where('highlight_sale', true)
            ->with(['images.mediaAsset'])
            ->latest('published_at')
            ->limit(4)
            ->get();

        $rentHighlights = Property::query()
            ->published()
            ->forRent()
            ->where('highlight_rent', true)
            ->with(['images.mediaAsset'])
            ->latest('published_at')
            ->limit(4)
            ->get();

        $weeklyDeal = Property::query()
            ->published()
            ->where('weekly_deal', true)
            ->with(['images.mediaAsset', 'amenities'])
            ->latest('published_at')
            ->first();

        return view('welcome', [
            'saleHighlights' => $saleHighlights,
            'rentHighlights' => $rentHighlights,
            'weeklyDeal' => $weeklyDeal,
        ]);
    }
}
