<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UploadResource;

class ApplicantController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tender_id' => 'required|exists:tenders,id', 
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', 
        ]);
    
        $filePath = $request->file('file')->store('applications', 'public'); 
    
        $application = Applicant::create([
            'tender_id' => $validatedData['tender_id'],
            'user_id' => Auth::user()->id,
            'files' => json_encode([$filePath]),
            'application_details' => 'tender'
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'application' =>new UploadResource($application),
        ], 201);
    }



    


}
