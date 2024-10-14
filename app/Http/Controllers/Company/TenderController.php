<?php

namespace App\Http\Controllers\Company;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tenders = Tender::with('company')->get();
        return view('company.tenders.index', compact('tenders'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = \App\Models\Company::all();
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
            ->generate(route('tenders.show', $tender->id)); // Assuming you want to link to the tender details page
    
        return view('company.tenders.show', compact('tender', 'qrCode'));
    }
    public function generateQrCode($id)
    {
        $tender = Tender::findOrFail($id);
        
        
        return QrCode::size(400)
        ->backgroundColor(128, 128, 128)
            ->margin(1)
            ->generate(route('tenders.show', $tender->id)); // Link to the tender details
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
