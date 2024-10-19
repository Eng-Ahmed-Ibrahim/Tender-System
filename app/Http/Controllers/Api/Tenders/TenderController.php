<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenderResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::all();

        return TenderResource::collection($tenders);
    }

    public function show($id)
    {
        // Retrieve the tender using findOrFail to throw an exception if not found
        $tender = Tender::findOrFail($id);
    
        // Return the TenderResource, which handles QR code generation and formatting
        return new TenderResource($tender);
    }
    

}
