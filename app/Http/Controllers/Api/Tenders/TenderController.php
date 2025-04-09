<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Configuration;
use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TenderResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => __('User not authenticated.'),
            ], 401);
        }
    
        $currentDate = now();
        $user = auth()->user();
        
        // Get request parameters
        $sortType = $request->input('sort');
        $search = $request->input('search');
        $city = $request->input('city');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minInsurance = $request->input('min_insurance');
        $maxInsurance = $request->input('max_insurance');
        $endDateFilter = $request->input('end_date_filter');
    
        // Initialize query based on sort type
        if ($sortType === 'favorite') {
            // If favorite sort is selected, get only favorite tenders
            $query = $user->favoriteTenders();
        } else {
            // Otherwise, get applied tenders
            $appliedTenderIds = Applicant::where('user_id', $user->id)
                ->pluck('tender_id');
            $query = Tender::whereIn('id', $appliedTenderIds);
        }
    
        // Apply sorting
        switch ($sortType) {
            case 'current':
                $query->where('end_date', '>', $currentDate);
                break;
            case 'previous':
                $query->where('end_date', '<=', $currentDate);
                break;
            case 'favorite':
                // Already handled above, no additional filtering needed
                break;
            case 'lowest_price':
                $query->orderBy('price', 'asc');
                break;
            case 'highest_price':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    
        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
    
        // Apply city filter
        if ($city) {
            $query->where('city', $city);
        }
    
        // Apply price range filter
        if ($minPrice && $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($minPrice) {
            $query->where('price', '>=', $minPrice);
        } elseif ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
    
        // Apply insurance range filter
        if ($minInsurance && $maxInsurance) {
            $query->whereBetween('first_insurance', [$minInsurance, $maxInsurance]);
        } elseif ($minInsurance) {
            $query->where('first_insurance', '>=', $minInsurance);
        } elseif ($maxInsurance) {
            $query->where('first_insurance', '<=', $maxInsurance);
        }
    
        // Apply end date filter
        switch ($endDateFilter) {
            case 'less_than_day':
                $query->whereBetween('end_date', [
                    $currentDate,
                    $currentDate->copy()->addDay()
                ]);
                break;
            case 'less_than_week':
                $query->whereBetween('end_date', [
                    $currentDate,
                    $currentDate->copy()->addWeek()
                ]);
                break;
            case 'less_than_month':
                $query->whereBetween('end_date', [
                    $currentDate,
                    $currentDate->copy()->addMonth()
                ]);
                break;
        }
    
        $tenders = $query->get();
    
        return TenderResource::collection($tenders);
    }
    public function min_max_insurance()
{
    $lowestPrice  = Tender::min('first_insurance');
    $highPrice  = Tender::max('first_insurance');

    return response()->json([
        'min_tender_insurance' => $lowestPrice,
        'max_tender_insurance' => $highPrice,
    ]);

 
} 
    

    public function show($id)
    {
        // Retrieve the tender using findOrFail to throw an exception if not found
        $tender = Tender::findOrFail($id);
    
        // Return the TenderResource, which handles QR code generation and formatting
        return new TenderResource($tender);
    }
    
    public function configuration()
    {
        $configuration = Configuration::first();
        if (!$configuration) {
            $configuration = Configuration::create();
        }       

        return response()->json([
            'configuration' => $configuration
        ]);
    }


}
