<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'applicant')
            ->with(['applicants' => function($query) {
                $query->with(['tender.company']); // Eager load tender and company
            }]);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhereHas('applicants.tender', function($q) use ($searchTerm) {
                      $q->where('title', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by tender
        if ($request->filled('tender')) {
            $query->whereHas('applicants', function($q) use ($request) {
                $q->where('tender_id', $request->tender);
            });
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->whereHas('applicants.tender', function($q) use ($request) {
                $q->where('company_id', $request->company);
            });
        }

        // Filter by date
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereHas('applicants', function($q) use ($request) {
                $q->whereBetween('created_at', [
                    Carbon::parse($request->date_from)->startOfDay(),
                    Carbon::parse($request->date_to)->endOfDay()
                ]);
            });
        }

        $applicants = $query->paginate(10)->withQueryString();
        
        // Get unique tenders and companies for filters
        $tenders = Tender::whereHas('applicants')->with('company')->get();
        $companies = $tenders->pluck('company')->unique();

        // Get statistics
        $statistics = [
            'total_applicants' => $query->count(),
            'total_applications' => Applicant::count(),
            'recent_applications' => Applicant::where('created_at', '>=', now()->subDays(30))->count(),
            'active_tenders' => Tender::whereHas('applicants')->where('end_date', '>', now())->count()
        ];

        if ($request->ajax()) {
            return view('backend.applicants.partials.applicant-list', 
                compact('applicants'))->render();
        }

        return view('backend.applicants.index', 
            compact('applicants', 'tenders', 'companies', 'statistics'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
