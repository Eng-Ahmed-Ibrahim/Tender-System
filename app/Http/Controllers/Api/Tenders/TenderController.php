<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\Configuration;
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
        $country_id = $request->input('country_id');
        $city_id = $request->input('city_id');

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

        if ($country_id)
            $query->where("country_id", $country_id);

        if ($city_id)
            $query->where("city_id", $city_id);

        $tenders = $query->with(['country:id,name,name_ar,currency,currency_ar', 'city:id,name,name_ar', 'applicants'])->get();


        return response()->json([
            "status" => 201,
            "message" => "Tenders",
            "data" => TenderResource::collection($tenders),
        ]);
    }



    public function getCities()
    {
        // Define standard Egyptian cities with both English and Arabic names
        $standardCities = [
            ['id' => 1, 'name_en' => 'Alexandria', 'name_ar' => 'الإسكندرية'],
            ['id' => 2, 'name_en' => 'Assiut', 'name_ar' => 'أسيوط'],
            ['id' => 3, 'name_en' => 'Aswan', 'name_ar' => 'أسوان'],
            ['id' => 4, 'name_en' => 'Beni Suef', 'name_ar' => 'بني سويف'],
            ['id' => 5, 'name_en' => 'Cairo', 'name_ar' => 'القاهرة'],
            ['id' => 6, 'name_en' => 'Damanhour', 'name_ar' => 'دمنهور'],
            ['id' => 7, 'name_en' => 'Damietta', 'name_ar' => 'دمياط'],
            ['id' => 8, 'name_en' => 'Faiyum', 'name_ar' => 'الفيوم'],
            ['id' => 9, 'name_en' => 'Giza', 'name_ar' => 'الجيزة'],
            ['id' => 10, 'name_en' => 'Hurghada', 'name_ar' => 'الغردقة'],
            ['id' => 11, 'name_en' => 'Ismailia', 'name_ar' => 'الإسماعيلية'],
            ['id' => 12, 'name_en' => 'Luxor', 'name_ar' => 'الأقصر'],
            ['id' => 13, 'name_en' => 'Mansoura', 'name_ar' => 'المنصورة'],
            ['id' => 14, 'name_en' => 'Port Said', 'name_ar' => 'بورسعيد'],
            ['id' => 15, 'name_en' => 'Qena', 'name_ar' => 'قنا'],
            ['id' => 16, 'name_en' => 'Sharm El Sheikh', 'name_ar' => 'شرم الشيخ'],
            ['id' => 17, 'name_en' => 'Shubra El Kheima', 'name_ar' => 'شبرا الخيمة'],
            ['id' => 18, 'name_en' => 'Smoha', 'name_ar' => 'سموحة'],
            ['id' => 19, 'name_en' => 'Sohag', 'name_ar' => 'سوهاج'],
            ['id' => 20, 'name_en' => 'Suez', 'name_ar' => 'السويس'],
            ['id' => 21, 'name_en' => 'Tanta', 'name_ar' => 'طنطا'],
        ];

        // Get city names from existing tenders
        $tenderCities = Tender::pluck('city')->toArray();

        // Filter out null/empty values
        $tenderCities = array_filter($tenderCities, function ($city) {
            return !is_null($city) && trim($city) !== '';
        });

        // Standardize capitalization of tender cities
        $tenderCities = array_map(function ($city) {
            return ucfirst(strtolower(trim($city)));
        }, $tenderCities);

        // Remove duplicates from tender cities
        $uniqueTenderCities = array_values(array_unique($tenderCities));

        // Get standard city names in English
        $standardCityNames = array_map(function ($city) {
            return $city['name_en'];
        }, $standardCities);

        // Find tender cities that are not in our standard list
        $newCities = array_diff($uniqueTenderCities, $standardCityNames);

        // Add any new cities to our list with empty Arabic names
        // Start ID from the next available number
        $nextId = count($standardCities) + 1;
        foreach ($newCities as $cityName) {
            $standardCities[] = [
                'id' => $nextId++,
                'name_en' => $cityName,
                'name_ar' => '' // Empty Arabic name for now
            ];
        }

        // Sort the final list by English name
        usort($standardCities, function ($a, $b) {
            return strcmp($a['name_en'], $b['name_en']);
        });

        return response()->json([
            'status' => true,
            'message' => 'Cities retrieved successfully',
            'data' => $standardCities
        ]);
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


    public function show(Request $request, $id)
    {
        // Retrieve the tender using findOrFail to throw an exception if not found
        $tender = Tender::where("id", $id)
            ->with(['applicants' => function ($query) use ($request) {
                $query->where('users.id', $request->user()->id);
            }])
            ->first();
        if (! $tender)
            return response()->json([
                "status" => 404,
                "message" => "Not Found",

            ]);

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
