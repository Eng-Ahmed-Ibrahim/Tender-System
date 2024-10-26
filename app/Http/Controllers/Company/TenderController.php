<?php

namespace App\Http\Controllers\Company;

use Carbon\Carbon;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $query = Tender::query();
 
         // Apply role-based filtering
         if (auth()->user()->role === 'company') {
             $query->where('company_id', auth()->user()->id);
         }
 
         // Search functionality
         if ($request->filled('search')) {
             $searchTerm = $request->search;
             $query->where(function ($q) use ($searchTerm) {
                 $q->where('title', 'LIKE', "%{$searchTerm}%")
                   ->orWhere('description', 'LIKE', "%{$searchTerm}%");
             });
         }
 
         // Date range filter
         if ($request->filled('start_date') && $request->filled('end_date')) {
             $query->whereBetween('end_date', [$request->start_date, $request->end_date]);
         }
 
         // Company filter (for admin users)
         if (auth()->user()->role === 'admin' && $request->filled('company')) {
             $query->where('company_id', $request->company);
             
             // Debugging: Log the company ID and the resulting SQL query
             Log::info('Filtering by company ID: ' . $request->company);
             Log::info('SQL Query: ' . $query->toSql());
             Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
         }
 
         // Status filter based on end_date
         if ($request->filled('status')) {
             $now = Carbon::now();
             if ($request->status === 'open') {
                 $query->where('end_date', '>', $now);
             } elseif ($request->status === 'closed') {
                 $query->where('end_date', '<=', $now);
             }
         }
 
         $tenders = $query->latest()->paginate(10);
 
         // Debugging: Log the count of tenders
         Log::info('Number of tenders retrieved: ' . $tenders->count());
 
         $companies = auth()->user()->role === 'admin' ? \App\Models\Company::all() : null;
 
         return view('company.tenders.index', compact('tenders', 'companies'));
     }
 
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = User::where('role','company')->get();
        return view('company.tenders.create', compact('companies'));  
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'first_insurance' => 'number|max:255',
            'last_insurance' => 'number|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date',
            'show_applicants' => 'boolean',
        ]);

        $qrCode =  QrCode::generate(url('/tenders/' . $validatedData['company_id']));

        $qrCodePath = 'qrcodes/tender_' . time() . '.svg'; //
        Storage::disk('public')->put($qrCodePath, $qrCode);

        $tender = Tender::create(array_merge($validatedData, ['qr_code' => $qrCodePath]));

        return response()->json(['success' => true, 'message' => 'Tender created successfully.', 'tender' => $tender]);
        }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tender = Tender::findOrFail($id);
    
        $qrCode = QrCode::size(200)
            ->backgroundColor(255, 255, 0)
            ->color(0, 0, 255)
            ->margin(1)
            ->generate(route('tenders.show', $tender->id)); 
    
        return view('company.tenders.show', compact('tender', 'qrCode'));
    }
    public function generateQrCode($id)
    {
        $tender = Tender::findOrFail($id);
        
        
        return QrCode::size(400)
        ->backgroundColor(128, 128, 128)
            ->margin(1)
            ->generate(route('tenders.show', $tender->id)); 
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        $companies = \App\Models\Company::all();

        return view('company.tenders.edit',compact('tender','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'company_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'first_insurance' => 'number|max:255',
        'last_insurance' => 'number|max:255',
        'description' => 'required|string',
        'end_date' => 'required|date',
        'show_applicants' => 'boolean',
    ]);

    // Find the tender by ID
    $tender = Tender::findOrFail($id);

    // Update the QR code if the company_id or relevant details change
    if ($tender->company_id !== $validatedData['company_id'] || $tender->title !== $validatedData['title']) {
        $qrCode = QrCode::generate(url('/tenders/' . $validatedData['company_id']));
        $qrCodePath = 'qrcodes/tender_' . time() . '.svg';
        Storage::disk('public')->put($qrCodePath, $qrCode);

        $validatedData['qr_code'] = $qrCodePath;
    }

    // Update the tender record
    $tender->update($validatedData);

    // Return a response indicating success
    return response()->json(['success' => true, 'message' => 'Tender updated successfully.', 'tender' => $tender]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download($id)
    {
        // Find the tender by ID
        $tender = Tender::findOrFail($id);
    
        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate(route('tenders.show', $tender->id));
    
        return response()->stream(
            function () use ($qrCode) {
                echo $qrCode;
            },
            200, // HTTP status code
            [
                'Content-Type' => 'image/png',
            ]
        );
    }
    
}
