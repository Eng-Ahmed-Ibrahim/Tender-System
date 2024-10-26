<?php

namespace App\Http\Controllers\Api\Tenders;

use Exception;
use Carbon\Carbon;
use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UploadResource;
use Illuminate\Support\Facades\Storage;

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
            'file' => 'sometimes|file', // Use 'sometimes' to allow optional file
        ]);
    
        $userId = Auth::user()->id;
    
        // Check if the user has already submitted an application for this tender
        $application = Applicant::where('tender_id', $validatedData['tender_id'])
            ->where('user_id', $userId)
            ->first();
    
        $tender = Tender::findOrFail($validatedData['tender_id']);
        $deadline = $tender->edit_end_date;
    
        // Check if the deadline for modifying the application has passed
        if ($application && now()->greaterThan($deadline)) {
            return response()->json([
                'success' => false,
                'message' => 'انتهت المهلة لتعديل الطلب.' // The deadline for modifying the application has passed
            ], 403);
        }
    
        if (!$application) {
            // Store the uploaded file
            $filePath = $request->file('file')->store('applications', 'public');
    
            // Create a new application record
            $application = Applicant::create([
                'tender_id' => $validatedData['tender_id'],
                'user_id' => $userId,
                'files' => $filePath,
                'application_details' => 'تقديم طلب جديد', // New application details
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully.',
                'application' => new UploadResource($application),
            ], 201); // Created
        } else {
            // If an application exists, update it
            if ($request->hasFile('file')) {
                // Store the new file
                $filePath = $request->file('file')->store('applications', 'public');
                $application->files = $filePath; // Update the file path
            }
    
            // Update other fields if necessary
            $application->tender_id = $validatedData['tender_id'];
            $application->application_details = 'تعديل على الطلب'; // Modify this as needed
    
            // Save the updated applicant record
            $application->save();
    
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الطلب بنجاح.', // Application updated successfully.
                'application' => new UploadResource($application),
            ]);
        }
    }
    
    public function deleteFile(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tender_id' => 'required|exists:tenders,id'
        ]);
    
        $userId = Auth::user()->id;
    
        // Find the application
        $application = Applicant::where('tender_id', $validatedData['tender_id'])
            ->where('user_id', $userId)
            ->first();
    
        // Check if application exists
        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على الطلب.' // Application not found
            ], 404);
        }
    
        // Get the tender to check deadline
        $tender = Tender::findOrFail($validatedData['tender_id']);
        $deadline = $tender->edit_end_date;
    
        // Check if the deadline for modifying the application has passed
        if (now()->greaterThan($deadline)) {
            return response()->json([
                'success' => false,
                'message' => 'انتهت المهلة لتعديل الطلب.' // The deadline for modifying the application has passed
            ], 403);
        }
    
        try {
            // Begin transaction
            DB::beginTransaction();
    
            // Delete the physical file if it exists
            if ($application->files && Storage::disk('public')->exists($application->files)) {
                Storage::disk('public')->delete($application->files);
            }
            
            // Delete the application record
            $application->delete();
    
            // Commit transaction
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطلب بنجاح.' // Application deleted successfully
            ]);
    
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'فشل في حذف الطلب.', // Failed to delete application
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}