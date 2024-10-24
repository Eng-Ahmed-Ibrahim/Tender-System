<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FcmController extends Controller
{

   public function sendToUser(Request $request): JsonResponse
   {
       $request->validate([
           'user_id' => 'required|exists:users,id',
           'device_token' => 'nullable|string'
       ]);

       try {
           $user = User::findOrFail($request->user_id);
           
           // Update device token if provided
           if ($request->has('device_token')) {
               $user->device_token = $request->device_token;
               $user->save();
           }

           // Check if user has device token
           if (empty($user->device_token)) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'User does not have a device token'
               ], 400);
           }

           $user->notify(new TestNotification());

           return response()->json([
               'status' => 'success',
               'message' => 'Notification sent successfully',
               'data' => [
                   'user_id' => $user->id,
                   'device_token' => $user->device_token
               ]
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to send notification',
               'error' => $e->getMessage()
           ], 500);
       }
   }

   /**
    * Send test notification to multiple users
    */
   public function sendToMultipleUsers(Request $request): JsonResponse
   {
       $request->validate([
           'user_ids' => 'required|array',
           'user_ids.*' => 'exists:users,id'
       ]);

       try {
           $users = User::whereIn('id', $request->user_ids)
                       ->whereNotNull('device_token')
                       ->get();

           if ($users->isEmpty()) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'No users found with device tokens'
               ], 400);
           }

           Notification::send($users, new TestNotification());

           return response()->json([
               'status' => 'success',
               'message' => 'Notifications sent successfully',
               'data' => [
                   'total_users' => $users->count(),
                   'user_ids' => $users->pluck('id')
               ]
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to send notifications',
               'error' => $e->getMessage()
           ], 500);
       }
   }

   /**
    * Update device token for a user
    */
   public function updateDeviceToken(Request $request): JsonResponse
   {
       $request->validate([
           'user_id' => 'required|exists:users,id',
           'device_token' => 'required|string'
       ]);

       try {
           $user = User::findOrFail($request->user_id);
           $user->device_token = $request->device_token;
           $user->save();

           return response()->json([
               'status' => 'success',
               'message' => 'Device token updated successfully',
               'data' => [
                   'user_id' => $user->id,
                   'device_token' => $user->device_token
               ]
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to update device token',
               'error' => $e->getMessage()
           ], 500);
       }
   }

   /**
    * Test endpoint to check FCM configuration
    */
   public function testConfiguration(): JsonResponse
   {
       return response()->json([
           'status' => 'success',
           'message' => 'FCM test endpoint reached successfully',
           'config' => [
               'fcm_server_key_configured' => !empty(config('services.fcm.key')),
               'notification_channel_installed' => class_exists(\NotificationChannels\Fcm\FcmChannel::class)
           ]
       ]);
   }}
