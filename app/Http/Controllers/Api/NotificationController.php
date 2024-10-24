<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirebaseService;

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
            $response = $this->firebaseService->sendNotification(
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
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}