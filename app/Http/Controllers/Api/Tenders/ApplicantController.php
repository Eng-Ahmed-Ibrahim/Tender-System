<?php

namespace App\Http\Controllers\Api\Tenders;

use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UploadResource;

class ApplicantController extends Controller
{



    public function getUsersByTenderId($tenderId)
    {


        $tender = Tender::findOrFail($tenderId);
    
        $users = $tender->applicants;
    
        return UserResource::collection($users);

        
    }





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
            'files' =>$filePath,
            'application_details' => 'tender'
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'application' =>new UploadResource($application),
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Make file optional for update
        ]);
    
        // Find the application by ID
        $application = Applicant::findOrFail($id);
    
        // Convert edit_end_date to a Carbon instance
        $editEndDate = \Carbon\Carbon::parse($application->edit_end_date);
    
        // Check if the current time is before the edit_end_date
        if (now()->greaterThanOrEqualTo($editEndDate)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit application after the deadline.',
            ], 403); // Forbidden response
        }
    
        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Store the new file and update the file path
            $filePath = $request->file('file')->store('applications', 'public');
            $application->files = $filePath; // Update the file path
        }
    
        // Update other application details if necessary
        $application->save(); // Save the application with the updated fields
    
        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully.',
            'application' => new UploadResource($application), // Use the resource to return the updated application
        ], 200); // OK response
    }
    
}