<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\DeviceNotification;

class NotificationController extends Controller
{
    public function storeFcmToken(Request $request)
    {
        // Validate the request to ensure 'fcm_token' is provided
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        // Assuming the user is authenticated
        $user = auth()->user();

        // Store or update the FCM token in the user's record
        $user->update([
            'fcm_token' => $request->fcm_token,
        ]);

        return response()->json(['message' => 'FCM token stored successfully']);
    }

    /**
     * Send a notification using FCM.
     */
    public function sendNotification(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'fcm_token' => 'required|string', // Device token
            'title' => 'required|string',     // Notification title
            'body' => 'required|string',      // Notification body
        ]);

        // Extract data from request
        $deviceToken = $request->input('fcm_token');
        $title = $request->input('title');
        $body = $request->input('body');

        // Send notification to the device using the token
        try {
            // Create a temporary notifiable entity
            $notifiable = new class {
                use \Illuminate\Notifications\Notifiable;
                public $device_token;
            };
            $notifiable->device_token = $deviceToken;

            // Notify the device using the DeviceNotification
            $notifiable->notify(new DeviceNotification($title, $body, $deviceToken));

            return response()->json(['message' => 'Notification sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send notification: ' . $e->getMessage()], 500);
        }
    }


}
