<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tender;
use App\Models\Company;
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
            ->whereHas('applicants')
            ->with(['applicants' => function($query) {
                $query->with(['tender.company']); 
            }]);
    
        if(auth()->user()->role == 'admin_company' || auth()->user()->role == 'company') {
            $companyId = auth()->user()->company_id;
            
            $query->whereHas('applicants.tender', function($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
    
            $tenders = Tender::where('company_id', $companyId)
                ->whereHas('applicants')
                ->get();
                
                $company = Company::find($companyId);
                $companies = $company ? collect([$company]) : collect([]);
    
            // Adjust statistics for company scope
            $statistics = [
                'total_applicants' => $query->count(),
                'total_applications' => Applicant::whereHas('tender', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })->count(),
                'recent_applications' => Applicant::whereHas('tender', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })->where('created_at', '>=', now()->subDays(30))->count(),
                'active_tenders' => Tender::where('company_id', $companyId)
                    ->whereHas('applicants')
                    ->where('end_date', '>', now())
                    ->count()
            ];
        } else {
            $tenders = Tender::whereHas('applicants')->with('company')->get();
            $companies = $tenders->pluck('company')->unique();
            
            $statistics = [
                'total_applicants' => $query->count(),
                'total_applications' => Applicant::count(),
                'recent_applications' => Applicant::where('created_at', '>=', now()->subDays(30))->count(),
                'active_tenders' => Tender::whereHas('applicants')->where('end_date', '>', now())->count()
            ];
        }
    
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name',$searchTerm);
        }
    
        // Filter by tender
        if ($request->filled('tender')) {
            $query->whereHas('applicants', function($q) use ($request) {
                $q->where('tender_id', $request->tender);
            });
        }
    
        // Filter by company (only for admin users)
        if (auth()->user()->role !== 'admin_company' && $request->filled('company')) {
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
    
        if ($request->ajax()) {
            return view('backend.applicants.partials.applicant-list',
                compact('applicants'))->render();
        }
    
        return view('backend.applicants.index',
            compact('applicants', 'tenders', 'companies', 'statistics'));
    }

    public function users(Request $request)
    {
        $query = User::query()
            ->where('role', 'applicant')
            ->with(['applicants' => function($query) {
                $query->with(['tender.company']); 
            }]);
    
        if(auth()->user()->role == 'admin_company') {
            $companyId = auth()->user()->company_id;
            
            $query->whereHas('applicants.tender', function($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
    
            $tenders = Tender::where('company_id', $companyId)
                ->whereHas('applicants')
                ->get();
                
                $company = Company::find($companyId);
                $companies = $company ? collect([$company]) : collect([]);
    
            // Adjust statistics for company scope
            $statistics = [
                'total_applicants' => $query->count(),
                'total_applications' => Applicant::whereHas('tender', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })->count(),
                'recent_applications' => Applicant::whereHas('tender', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                })->where('created_at', '>=', now()->subDays(30))->count(),
                'active_tenders' => Tender::where('company_id', $companyId)
                    ->whereHas('applicants')
                    ->where('end_date', '>', now())
                    ->count()
            ];
        } else {
            $tenders = Tender::whereHas('applicants')->with('company')->get();
            $companies = $tenders->pluck('company')->unique();
            
            $statistics = [
                'total_applicants' => $query->count(),
                'total_applications' => Applicant::count(),
                'recent_applications' => Applicant::where('created_at', '>=', now()->subDays(30))->count(),
                'active_tenders' => Tender::whereHas('applicants')->where('end_date', '>', now())->count()
            ];
        }
    
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name',$searchTerm);
        }
    
        // Filter by tender
        if ($request->filled('tender')) {
            $query->whereHas('applicants', function($q) use ($request) {
                $q->where('tender_id', $request->tender);
            });
        }
    
        // Filter by company (only for admin users)
        if (auth()->user()->role !== 'admin_company' && $request->filled('company')) {
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
    
        if ($request->ajax()) {
            return view('backend.applicants.partials.applicant-list',
                compact('applicants'))->render();
        }
    
        return view('backend.applicants.users',
            compact('applicants', 'tenders', 'companies', 'statistics'));
    }
   

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $applicant = User::with([
            'applicants' => function($query) {
                $query->latest();
            },
            'applicants.tender',
            'applicants.tender.company',
            'company'
        ])->findOrFail($id);

        // Get statistics
        $statistics = [
            'total_applications' => $applicant->applicants->count(),
            'active_applications' => $applicant->applicants->filter(function($application) {
                return $application->tender->end_date > now();
            })->count(),
            'documents_submitted' => $applicant->applicants->sum(function($application) {
                return count(json_decode($application->files) ?? []);
            }),
            'recent_activity' => $applicant->applicants->where('created_at', '>=', now()->subDays(30))->count()
        ];

        return view('backend.applicants.show', compact('applicant', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
/**
 * Show the form for creating a new applicant.
 */
public function create()
{
    // Get list of tenders to associate with applicant
    if(auth()->user()->role == 'admin_company') {
        $companyId = auth()->user()->company_id;
        $tenders = Tender::where('company_id', $companyId)
            ->where('end_date', '>', now())
            ->get();
    } else {
        $tenders = Tender::where('end_date', '>', now())->get();
    }
    
    // Get companies for selection (only for admin role)
    $companies = auth()->user()->role == 'admin_company' 
        ? collect([Company::find(auth()->user()->company_id)]) 
        : Company::all();
    
    return view('backend.applicants.create', compact('tenders', 'companies'));
}

/**
 * Show the form for editing the specified applicant.
 */
public function edit(string $id)
{
    $applicant = User::with([
        'applicants' => function($query) {
            $query->latest();
        },
        'applicants.tender',
        'company'
    ])->findOrFail($id);
    
    // Get list of tenders
    if(auth()->user()->role == 'admin_company') {
        $companyId = auth()->user()->company_id;
        $tenders = Tender::where('company_id', $companyId)->get();
        
        // Verify this applicant is accessible to this company admin
        $hasAccess = $applicant->applicants->some(function($application) use ($companyId) {
            return $application->tender->company_id == $companyId;
        });
        
        if (!$hasAccess) {
            abort(403, 'Unauthorized access');
        }
    } else {
        $tenders = Tender::all();
    }
    
    // Get companies for selection (only for admin role)
    $companies = auth()->user()->role == 'admin_company' 
        ? collect([Company::find(auth()->user()->company_id)]) 
        : Company::all();
    
    return view('backend.applicants.edit', compact('applicant', 'tenders', 'companies'));
}

/**
 * Store a newly created applicant in storage.
 */
public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'phone' => 'nullable|string|max:20',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'tender_id' => 'nullable|exists:tenders,id',
        'company_id' => 'nullable|exists:companies,id',
        'files' => 'nullable|array',
        'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);
    
    // Handle photo upload
    $photoName = null;
    if ($request->hasFile('photo')) {
        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('photos', $photoName, 'public');
    }
    
    // Create the user with applicant role
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'applicant',
        'company_id' => $request->company_id,
        'phone' => $request->phone,
        'photo' => $photoName,
    ]);
    
    // If tender is selected, create an application
    if ($request->tender_id) {
        $fileNames = [];
        
        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('applications', $fileName, 'public');
                $fileNames[] = $fileName;
            }
        }
        
        // Create the application
        Applicant::create([
            'user_id' => $user->id,
            'tender_id' => $request->tender_id,
            'files' => json_encode($fileNames),
            'status' => 'pending',
        ]);
    }
    
    return redirect()->back()
        ->with('success', __('Applicant created successfully.'));
}

/** 
 * Update the specified applicant in storage.
 */ 
public function update(Request $request, string $id)
{
    // Get the applicant
    $applicant = User::findOrFail($id);
    
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8',
        'phone' => 'nullable|string|max:20',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'company_id' => 'nullable|exists:companies,id',
        'tender_id' => 'nullable|exists:tenders,id',
        'files' => 'nullable|array',
        'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);
    
    // Update user data
    $applicant->name = $request->name;
    $applicant->email = $request->email;
    $applicant->phone = $request->phone;
    
    // Handle photo upload
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($applicant->photo) {
            $oldPhotoPath = storage_path('app/public/photos/' . $applicant->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }
        
        // Store new photo
        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('photos', $photoName, 'public');
        $applicant->photo = $photoName;
    }
    
    if ($request->filled('password')) {
        $applicant->password = bcrypt($request->password);
    }
    
    if (auth()->user()->role != 'admin_company') {
        $applicant->company_id = $request->company_id;
    }
    
    $applicant->save();
    
    // Handle new tender application if specified
    if ($request->tender_id) {
        // Check if application already exists
        $applicationExists = Applicant::where('user_id', $applicant->id)
            ->where('tender_id', $request->tender_id)
            ->exists();
            
        if (!$applicationExists) {
            $fileNames = [];
            
            // Handle file uploads
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('applications', $fileName, 'public');
                    $fileNames[] = $fileName;
                }
            }
            
            // Create the new application
            Applicant::create([
                'user_id' => $applicant->id,
                'tender_id' => $request->tender_id,
                'files' => json_encode($fileNames),
                'status' => 'pending',
            ]);
        }
    }
    
    return redirect()->route('applicants.users')
        ->with('success', __('Applicant updated successfully.'));
}
    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the applicant
            $user = User::findOrFail($id);
            
            // Check if user is actually an applicant
            if ($user->role !== 'applicant') {
                return redirect()->back()->with('error', __('Only applicant users can be deleted from this section.'));
            }
            
            // Delete associated applications first
            $applications = Applicant::where('user_id', $id)->get();
            
            foreach ($applications as $application) {
                // Delete application files from storage
                $files = json_decode($application->files, true) ?? [];
                foreach ($files as $file) {
                    $filePath = storage_path('app/public/applications/' . $file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                
                // Now delete the application
                $application->delete();
            }
            
            // Delete profile photo if exists
            if ($user->photo) {
                $photoPath = storage_path('app/public/photos/' . $user->photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            
            // Delete the user
            $user->delete();
            
            return redirect()->back()->with('success', __('Applicant and all associated data deleted successfully.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Error deleting applicant: ' . $e->getMessage()));
        }
    }
}
