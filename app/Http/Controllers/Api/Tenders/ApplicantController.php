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

    public function deadline($tenderId) {

        $tender = Tender::findOrFail($tenderId);

        $deadline = $tender->edit_end_date;

        if (now()>$deadline){

            return response()->json([
                'message' => 'أنتهت المهلة للتعديل'
            ]);

        } else {

            $remainingDaysDecimal = now()->diffInDays($deadline);

            $remainingDays = floor($remainingDaysDecimal);

            $dayWord = ($remainingDays == 1) ? 'يوم' : 'أيام';

            return response()->json([
                'message' => "اخر موعد لتعديل الملف هو $remainingDays $dayWord"
            ]);


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
    public function update(Request $request) 
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'tender_id' => 'required|exists:tenders,id', 
            'file' => 'sometimes|file|mimes:pdf,doc,docx,jpg,png|max:2048', 
        ]);
    
        $userId = Auth::user()->id;

        $application = Applicant::findOrFail($userId);
    
        $tender = Tender::findOrFail($validatedData['tender_id']);

        $deadline = $tender->edit_end_date;
    
        if (now()->greaterThan($deadline)) {
            return response()->json([
                'success' => false,
                'message' => 'انتهت المهلة لتعديل الطلب.' // The deadline for modifying the application has passed
            ], 403);
        }
    
        // Update the applicant record
        if ($request->hasFile('file')) {
            // Store the new file
            $filePath = $request->file('file')->store('applications', 'public');
            $application->files = $filePath; // Update the file path
        }
    
        // Update other fields if necessary
        $application->tender_id = $validatedData['tender_id'];
        $application->application_details = 'تعديل على الطلب'; // You can modify this as needed
    
        // Save the updated applicant record
        $application->save();
    
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الطلب بنجاح.', // Application updated successfully.
            'application' => new UploadResource($application),
        ]);
    }
    
    
}