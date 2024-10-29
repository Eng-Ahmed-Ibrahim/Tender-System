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
        if (auth()->user()->role === 'admin_company') {
            return $this->companyDashboard();
        }
        
    }
    private function adminDashboard()
    {
        // Overall statistics
        $statistics = [
            'total_tenders' => Tender::count(),
            'active_tenders' => Tender::where('end_date', '>', now())->count(),
            'total_companies' => Company::count(),
            'total_applicants' => User::where('role', 'applicant')->count()
        ];
    
        // Recent tenders
        $recentTenders = Tender::with(['company', 'applicants'])
            ->latest()
            ->take(5)
            ->get();
    
        // Top companies by tenders
        $topCompanies = Company::withCount('tenders')
            ->withCount(['tenders as active_tenders_count' => function($query) {
                $query->where('end_date', '>', now());
            }])
            ->orderByDesc('tenders_count')
            ->take(5)
            ->get();
    
        // Monthly applications chart data
        $monthlyApplications = Applicant::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();
    
        // Recent applicants
        $recentApplicants = User::where('role', 'applicant')
            ->with(['applicants' => function($query) {
                $query->latest()->take(1);
            }, 'applicants.tender'])
            ->latest()
            ->take(5)
            ->get();
    
        // Status distribution instead of categories
        $tenderStatus = Tender::all();
           
    
        // Activity log (you'll need to implement activity logging)
        $recentActivities = [];  // Implement based on your activity logging system
    
        return view('backend.dashboard.admin', compact(
            'statistics',
            'recentTenders',
            'topCompanies',
            'monthlyApplications',
            'recentApplicants',
            'tenderStatus', // Changed from tenderCategories
            'recentActivities'
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
        $applicationStatus = Tender::where('company_id', $companyId)
            ->select(
                DB::raw('CASE 
                    WHEN end_date > NOW() THEN "Active" 
                    ELSE "Closed" 
                END as status'),
                DB::raw('count(*) as count')
            )
            ->groupBy('status')
            ->get();

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
