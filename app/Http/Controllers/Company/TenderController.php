<?php

namespace App\Http\Controllers\Company;

use Exception;
use Carbon\Carbon;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $query = Tender::query();
     
         if (auth()->user()->role === 'admin_company') {
             $query->where('company_id', auth()->user()->company_id);
         }
     
         if ($request->filled('search')) {
             $searchTerm = $request->search;
             $query->where(function ($q) use ($searchTerm) {
                 $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searcrm}%hTe");
             });
         }
     
         if ($request->filled('start_date') && $request->filled('end_date')) {
             $query->whereBetween('end_date', [
                 Carbon::parse($request->start_date)->startOfDay(),
                 Carbon::parse($request->end_date)->endOfDay()
             ]);
         }
     
         if (auth()->user()->role === 'admin' && $request->has('companies')) {
             $query->whereIn('company_id', $request->companies);
         }
     
         if ($request->filled('status')) {
             $now = Carbon::now();
             if ($request->status === 'open') {
                 $query->where('end_date', '>', $now);
             } elseif ($request->status === 'closed') {
                 $query->where('end_date', '<=', $now);
             }
         }
     
         switch ($request->get('sort', 'date-desc')) {
             case 'date-asc':
                 $query->oldest();
                 break;
             case 'title-asc':
                 $query->orderBy('title', 'asc');
                 break;
             case 'title-desc':
                 $query->orderBy('title', 'desc');
                 break;
             case 'date-desc':
             default:
                 $query->latest();
                 break;
         }
     
         $tenders = $query->paginate(10)->withQueryString();
         
         $companies = auth()->user()->role === 'admin' ? \App\Models\Company::all() : null;
     
         if ($request->ajax() && $request->has('partial')) {
            
             return view('company.tenders.partials.tender-grid', compact('tenders'))->render();
         }
     
         return view('company.tenders.index', compact('tenders', 'companies'));
     }
 
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies =\App\Models\Company::all();

        return view('company.tenders.create', compact('companies'));  
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'first_insurance' => 'required',
            'price' => 'required',
            'description' => 'required|string',
            'end_date' => 'required|date',
            'edit_end_date' => 'required|date',
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
            ->generate(url("/api/ApiAllTenders/{$tender->id}")); 

        return view('company.tenders.show', compact('tender', 'qrCode'));
    }
    public function generateQrCode($id)
    {
        $tender = Tender::findOrFail($id);
        
        
        return QrCode::size(400)
        ->backgroundColor(128, 128, 128)
            ->margin(1)
            ->generate(url("/api/ApiAllTenders/{$tender->id}"));  
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
        'company_id' => 'required|exists:companies,id',
        'title' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'first_insurance' => 'number|max:255',
        'price' => 'number|max:255',
        'description' => 'required|string',
        'end_date' => 'required|date',
        'edit_end_date' => 'required|date',
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
        $tender = Tender::findOrFail($id);
    
        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate(route('tenders.show', $tender->id));
    
        return response()->stream(
            function () use ($qrCode) {
                echo $qrCode;
            },
            200, 
            [
                'Content-Type' => 'image/png',
            ]
        );
    }


    public function stopTender($id)
    {
      
            $tender = Tender::findOrFail($id);
            
            if ($tender->end_date <= now()) {
                return redirect()->back()->with('error', __('Tender is already ended or stopped'));
            }
    
            DB::beginTransaction();
    
            $tender->update([
                'status' => 0,
                'end_date' => now()
            ]);

            DB::commit();
    
            return redirect()->back()->with('success', __('Tender has been stopped successfully'));
    
      
    }


    
}
