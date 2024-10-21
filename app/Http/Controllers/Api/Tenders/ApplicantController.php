<?php

namespace App\Http\Controllers\Api\Tenders;

use Carbon\Carbon;
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
    public function deadline($tenderId) 
    {
        // Retrieve the tender record by its ID
        $tender = Tender::findOrFail($tenderId);
    
        // Get the deadline date
        $deadline = $tender->edit_end_date;
    
        // Calculate remaining time
        $remainingMessage = $this->getRemainingTime($deadline);
    
        return response()->json([
            'deadline' => $remainingMessage
        ]);
    }
    
    private function getRemainingTime($deadline)
    {
        // Get the current date and time
        $currentDate = now();
        $deadlineDate = \Carbon\Carbon::parse($deadline);
    
        $difference = $currentDate->diff($deadlineDate);
        
        $remainingDays = $difference->days;
    
        if ($remainingDays > 0) {
            return "يتبقى {$remainingDays} أيام";
        } elseif ($remainingDays === 0) {
            return "يتبقى يوم واحد"; 
        } else {
            return "انتهت المهلة"; 
        }
    }
    




    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tender_id' => 'required|exists:tenders,id', 
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', 
        ]);
    
        // Check if the user has already submitted an application for this tender
        $existingApplication = Applicant::where('tender_id', $validatedData['tender_id'])
            ->where('user_id', Auth::user()->id)
            ->first();
    
        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted an application for this tender.',
            ], 400); // Bad Request
        }
    
        // Store the uploaded file
        $filePath = $request->file('file')->store('applications', 'public'); 
    
        // Create a new application record
        $application = Applicant::create([
            'tender_id' => $validatedData['tender_id'],
            'user_id' => Auth::user()->id,
            'files' => $filePath,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'application' => new UploadResource($application),
        ], 201); // Created
    }
    
    public function update(Request $request, $id)
    {
 
    
        $application = Applicant::findOrFail($id);
    
        $editEndDate = Carbon::parse($application->edit_end_date);
    
        if (now()->lessThan($editEndDate)) {
            
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('applications', 'public');
            $application->files = $filePath; 
        }
    
        $application->save(); // Save the application with the updated fields
    
        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully.',
            'application' => new UploadResource($application), // Use the resource to return the updated application
        ], 200); // OK response

        }
    
       
        return response()->json([
            'success' => false,
            'message' => 'Cannot edit application after the deadline.',
        ], 403); // Forbidden response
    }
    
}