<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tender;
use App\Models\Company;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        }
        
        return $this->adminDashboard();  
    }
     
    public function company()
    {
            return $this->companyDashboard();
         
         
    }
    private function adminDashboard()
{
    // Overall statistics
    $statistics = [
        'total_tenders' => Tender::count(),
        'active_tenders' => Tender::where('end_date', '>', now())->count(),
        'total_companies' => Company::count(),
        'total_applicants' => DB::table('applicants')->count()
    ];

    // Recent tenders
    $recentTenders = Tender::with(['company', 'applicants'])
        ->latest()
        ->take(5)
        ->get();

    // Top companies
    $topCompanies = Company::withCount('tenders')
        ->withCount(['tenders as active_tenders_count' => function($query) {
            $query->where('end_date', '>', now());
        }])
        ->withCount(['tenders as applicants_count' => function($query) {
            $query->select(DB::raw('sum(
                (select count(*) from applicants where applicants.tender_id = tenders.id)
            )'));
        }])
        ->orderByDesc('tenders_count')
        ->take(5)
        ->get();

    // Monthly applications - get last 6 months including empty months
    $months = collect();
    for ($i = 5; $i >= 0; $i--) {
        $months->push(now()->subMonths($i)->format('Y-m'));
    }

    $monthlyApplications = Applicant::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
        )
        ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

    // Fill in empty months with 0 counts
    $formattedMonthlyApplications = $months->map(function ($month) use ($monthlyApplications) {
        return [
            'month' => $month,
            'count' => $monthlyApplications->has($month) ? $monthlyApplications[$month]->count : 0
        ];
    });

    // Recent applicants
    $recentApplicants = Applicant::with(['user', 'tender'])
        ->latest()
        ->take(5)
        ->get();

    return view('backend.dashboard.admin', compact(
        'statistics',
        'recentTenders',
        'topCompanies',
        'formattedMonthlyApplications', // Changed from monthlyApplications
        'recentApplicants'
    ));
}
    private function companyDashboard()
    {
        $company = auth()->user()->company;
        $companyId = $company->id;

        // Company statistics
        $statistics = [
            'total_tenders' => Tender::where('company_id', $companyId)->count(),
            'active_tenders' => Tender::where('company_id', $companyId)
                ->where('end_date', '>', now())
                ->count(),
            'total_applicants' => Applicant::whereHas('tender', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->count(),
            'recent_applications' => Applicant::whereHas('tender', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->where('created_at', '>=', now()->subDays(30))->count()
        ];

        // Recent tenders
        $recentTenders = Tender::where('company_id', $companyId)
            ->with(['applicants'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly applications for company's tenders
        $monthlyApplications = Applicant::whereHas('tender', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();

        // Recent applicants for company's tenders
        $recentApplicants = Applicant::whereHas('tender', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->with(['user', 'tender'])
            ->latest()
            ->take(5)
            ->get();

        // Tender performance metrics
        $tenderPerformance = Tender::where('company_id', $companyId)
            ->select('title', 'end_date')
            ->withCount('applicants')
            ->latest()
            ->take(5)
            ->get();

        // Application status distribution
        $applicationStatus = Tender::all();
            

        return view('backend.dashboard.company', compact(
            'statistics',
            'recentTenders',
            'monthlyApplications',
            'recentApplicants',
            'tenderPerformance',
            'applicationStatus',
            'company'
        ));
    }
}
