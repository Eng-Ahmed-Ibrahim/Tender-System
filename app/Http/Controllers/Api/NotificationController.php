<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'array|nullable'
        ]);

        try {
            $this->firebaseService->sendNotification(
                $request->fcm_token,
                $request->title,
                $request->body,
                $request->data ?? []
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Notification sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Notification error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send notification'
            ], 500);
        }
    }
}