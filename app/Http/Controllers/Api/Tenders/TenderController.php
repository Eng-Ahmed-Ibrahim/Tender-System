<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TenderResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    public function index(Request $request)
{
    // Get the current date for comparison
    $currentDate = now();

    // Create a query for Tenders
    $query = Tender::query();

    // Get the sorting type from the request
    $sortType = $request->input('sort');

    // Get the search input from the request
    $search = $request->input('search');

    // Get the authenticated user
    $user = Auth::user();

    // Apply sorting based on the sort type
    switch ($sortType) {
        case 'current':
            // Current tenders: end_date > current date
            $query->where('end_date', '>', $currentDate);
            break;
        case 'previous':
            // Previous tenders: end_date <= current date
            $query->where('end_date', '<=', $currentDate);
            break;
        case 'favorite':
            if ($user) {
                // Favorite tenders for the authenticated user
                $favoriteTenderIds = $user->favoriteTenders->pluck('id')->toArray();
                $query->whereIn('id', $favoriteTenderIds);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.',
                ], 401);
            }
            break;
        default:
            // Default sorting: order by created_at (or end_date as needed)
            $query->orderBy('created_at', 'desc');
            break;
    }

    // Apply search filter if a search term is provided
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', '%' . $search . '%')
              ->orWhere('description', 'LIKE', '%' . $search . '%');
        });
    }

    // Execute the query and retrieve the tenders
    $tenders = $query->get();

    // Return the tenders as a collection resource
    return TenderResource::collection($tenders);
}

    
    

    public function show($id)
    {
        // Retrieve the tender using findOrFail to throw an exception if not found
        $tender = Tender::findOrFail($id);
    
        // Return the TenderResource, which handles QR code generation and formatting
        return new TenderResource($tender);
    }
    

}
