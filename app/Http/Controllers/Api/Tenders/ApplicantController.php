<?php

namespace App\Http\Controllers\Api\Tenders;

use Exception;
use Carbon\Carbon;
use App\Models\Tender;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function deadline(Request $request ,$tenderId)
    {

        $tender = Tender::findOrFail($tenderId);

        $deadline = $tender->edit_end_date;

        if (now() > $deadline) {

            return response()->json([
                'message' => __('period of edit has finished')
            ]);
        } else {

            $remainingDaysDecimal = now()->diffInDays($deadline);

            $remainingDays = floor($remainingDaysDecimal);

            $dayWord = ($remainingDays == 1) ? 'يوم' : 'أيام';

return response()->json([
     'message' => trans_choice('last_time_update', $remainingDays, ['count' => $remainingDays]),
    "data"=>[
        "deadline"=>$deadline,
    ],
]);
        }
    }





    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'tender_id' => 'required|exists:tenders,id',
            'file' => 'sometimes|file', // Use 'sometimes' to allow optional file
            'financial_file' => 'sometimes|file', // Use 'sometimes' to allow optional file
            'quantity_file' => 'sometimes|file', // Use 'sometimes' to allow optional file
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
        $end_date = $tender->end_date;

        // Ensure $end_date is a Carbon instance
        if (!($end_date instanceof \Carbon\Carbon)) {
            $end_date = \Carbon\Carbon::parse($end_date);
        }
        $current_time = now();
        // For existing applications, check if the deadline has passed
        if ($application) {
            if ($current_time > $end_date) {
                return response()->json([
                    'success' => false,
                    'message' => __("The order time has expired.") // The deadline for modifying the application has passed
                ], 403);
            }
        } else {
            // For new applications, check if the tender end_date has passed
            if ($current_time > $end_date) {
                return response()->json([
                    'success' => false,
                    'message' => __("The deadline for submitting the tender has passed.") // The deadline for tender submission has passed
                ], 403);
            }
        }

        if (!$application) {
            // Store the uploaded file
            $filePath = $request->file('file')->store('applications', 'public');
            $fileQunatityFile = $request->file('quantity_file')->store('applications', 'public');
            $fileFinancialFile = $request->file('financial_file')->store('applications', 'public');

            // Create a new application record
            $application = Applicant::create([
                'tender_id' => $validatedData['tender_id'],
                'user_id' => $userId,
                'files' => $filePath,
                "quantity_file" => $fileQunatityFile,
                "financial_file" => $fileFinancialFile,
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

            if ($request->hasFile('quantity_file')) {
                // Store the new file
                $filePath = $request->file('quantity_file')->store('applications', 'public');
                $application->quantity_file = $filePath; // Update the file path
            }

            if ($request->hasFile('financial_file')) {
                // Store the new file
                $filePath = $request->file('financial_file')->store('applications', 'public');
                $application->financial_file = $filePath; // Update the file path
            }

            // Update other fields if necessary
            $application->tender_id = $validatedData['tender_id'];
            $application->application_details = 'تعديل على الطلب'; // Modify this as needed

            // Save the updated applicant record
            $application->save();

            return response()->json([
                'success' => true,
                'message' => __("The request has been updated successfully."), // Application updated successfully.
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
                'message' => __("Request not found.") // Application not found
            ], 404);
        }

        // Get the tender to check deadline
        $tender = Tender::findOrFail($validatedData['tender_id']);
        $deadline = $tender->edit_end_date;

        // Check if the deadline for modifying the application has passed
        if (now()->greaterThan($deadline)) {
            return response()->json([
                'success' => false,
                'message' => __('The deadline to modify the request has expired.') // The deadline for modifying the application has passed
            ], 403);
        }

        try {
            // Begin transaction
            DB::beginTransaction();

            // Delete the physical file if it exists
            if ($application->files && Storage::disk('public')->exists($application->files)) {
                Storage::disk('public')->delete($application->files);
            }
            if ($application->financial_file && Storage::disk('public')->exists($application->financial_file)) {
                Storage::disk('public')->delete($application->financial_file);
            }
            if ($application->quantity_file && Storage::disk('public')->exists($application->quantity_file)) {
                Storage::disk('public')->delete($application->quantity_file);
            }

            // Delete the application record
            $application->delete();

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Deleted Successfully') // Application deleted successfully
            ]);
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('Failed to delete request.'), // Failed to delete application
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
