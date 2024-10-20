<?php

namespace App\Http\Controllers\Api;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request, $tenderId)
    {
        $tender = Tender::findOrFail($tenderId);
        Auth::user()->favoriteTenders()->attach($tender);

        return response()->json([
            'success' => true,
            'message' => 'Tender added to favorites.',
        ]);
    }

    // Remove a tender from favorites
    public function destroy(Request $request, $tenderId)
    {
        $tender = Tender::findOrFail($tenderId);
        Auth::user()->favoriteTenders()->detach($tender);

        return response()->json([
            'success' => true,
            'message' => 'Tender removed from favorites.',
        ]);
    }
}
