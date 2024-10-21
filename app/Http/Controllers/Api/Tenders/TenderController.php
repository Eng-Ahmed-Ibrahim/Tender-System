<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TenderResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now();
    
        // Create a query for Tenders
        $query = Tender::query();
    
        // Get the sorting type, search input, and other filters from the request
        $sortType = $request->input('sort');
        $search = $request->input('search');
        $city = $request->input('city');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minInsurance = $request->input('min_insurance');
        $maxInsurance = $request->input('max_insurance');
        $endDateFilter = $request->input('end_date_filter');
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Apply sorting and filtering based on the sort type
        switch ($sortType) {
            case 'current':
                $query->where('end_date', '>', $currentDate);
                break;
            case 'previous':
                $query->where('end_date', '<=', $currentDate);
                break;
            case 'favorite':
                if ($user) {
                    $favoriteTenderIds = $user->favoriteTenders->pluck('id')->toArray(); 
                    $query->whereIn('id', $favoriteTenderIds);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not authenticated.',
                    ], 401);
                }
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
    
        // Apply search filter if a search term is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
    
        // Apply city filter if provided
        if ($city) {
            $query->where('city', $city);
        }
    
        $highestPrice = Tender::max('first_insurance');
    
        // Apply insurance range filter if provided
        if ($minInsurance) {
            $query->where('first_insurance', '>=', $minInsurance);
        }
        if ($maxInsurance) {
            $query->where('first_insurance', '<=', $maxInsurance);
        }
    
        // Apply end date filter
        switch ($endDateFilter) {
            case 'less_than_day':
                $query->whereBetween('end_date', [$currentDate, $currentDate->copy()->addDay()]);
                break;
            case 'less_than_week':
                $query->whereBetween('end_date', [$currentDate, $currentDate->copy()->addWeek()]);
                break;
            case 'less_than_month':
                $query->whereBetween('end_date', [$currentDate, $currentDate->copy()->addMonth()]);
                break;
        }
    
        // Execute the query and retrieve the tenders
        $tenders = $query->get();
    
        // Return the tenders as a collection resource
        return TenderResource::collection($tenders);
    }
    public function min_max_insurance()
    {
        // Get the lowest and highest insurance prices after casting to float
        $lowestPrice  = Tender::min(DB::raw('CAST(first_insurance AS DECIMAL)'));
        $highestPrice = Tender::max(DB::raw('CAST(first_insurance AS DECIMAL)'));
    
        // Check if the values are null and handle accordingly
        if (is_null($lowestPrice) || is_null($highestPrice)) {
            return response()->json([
                'success' => false,
                'message' => 'No insurance data available.',
                'min_tender_insurance' => $lowestPrice,
                'max_tender_insurance' => $highestPrice,
            ]);
        }
    
        // Return the min and max insurance prices
        return response()->json([
            'success' => true,
            'min_tender_insurance' => $lowestPrice,
            'max_tender_insurance' => $highestPrice,
        ]);
    }
     

    public function show($id)
    {
        // Retrieve the tender using findOrFail to throw an exception if not found
        $tender = Tender::findOrFail($id);
    
        // Return the TenderResource, which handles QR code generation and formatting
        return new TenderResource($tender);
    }
    

}
