<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                // Favorite tenders for the authenticated user
                $favoriteTenderIds = $request->user()->favoriteTenders->pluck('id')->toArray();
                $query->whereIn('id', $favoriteTenderIds);
                break;
            default:
                // Default sorting: order by created_at (or end_date as needed)
                $query->orderBy('created_at', 'desc');
                break;
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
