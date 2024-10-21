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
        try {
            $tender = Tender::findOrFail($tenderId);
            $deadline = $tender->edit_end_date;
            
            if (!$deadline) {
                return response()->json([
                    'error' => 'تاريخ انتهاء التعديل غير محدد'
                ], 400);
            }
    
            $remainingMessage = $this->getRemainingTime($deadline);
    
            return response()->json([
                'deadline' => $remainingMessage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء حساب الوقت المتبقي'
            ], 500);
        }
    }
    
    private function getRemainingTime($deadline)
    {
        $currentDate = now();
        $deadlineDate = \Carbon\Carbon::parse($deadline);
    
        if ($currentDate->greaterThan($deadlineDate)) {
            return "انتهت المهلة";
        }
    
        $difference = $currentDate->diff($deadlineDate);
    
        $days = $difference->days;
        $hours = $difference->h;
        $minutes = $difference->i;
    
        $parts = [];
    
        if ($days > 0) {
            $parts[] = "{$days} " . ($days == 1 ? "يوم" : "أيام");
        }
    
        if ($hours > 0 || $days > 0) {
            $parts[] = "{$hours} " . ($hours == 1 ? "ساعة" : "ساعات");
        }
    
        if ($minutes > 0 || $hours > 0 || $days > 0) {
            $parts[] = "{$minutes} " . ($minutes == 1 ? "دقيقة" : "دقائق");
        }
    
        if (empty($parts)) {
            return "يتبقى أقل من دقيقة";
        }
    
        return "يتبقى " . implode(" و ", $parts);
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