<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class UserNotifcationController extends Controller
{
    public function getNotifications()
    {
        try {
            $notifications = Notification::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'notifications' => $notifications,
                    'unread_count' => $this->getUnreadCount()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('Failed to fetch notifications')
            ], 500);
        }
    }

    // Mark single notification as read
    public function markAsRead($id)
    {
        try {
            $notification = Notification::where('user_id', auth()->id())
                ->where('id', $id)
                ->first();

            if (!$notification) {
                return response()->json([
                    'status' => 'error',
                    'message' =>  __('Notification not found')
                ], 404);
            }

            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' =>  __('Notification marked as read'),
                'unread_count' => $this->getUnreadCount()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('Failed to mark notification as read')
            ], 500);
        }
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        try {
            Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'status' => 'success',
                'message' =>  __('All notifications marked as read'),
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('Failed to mark notifications as read')
            ], 500);
        }
    }

    // Get unread notifications only
    public function getUnreadNotifications()
    {
        try {
            $notifications = Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'notifications' => $notifications,
                    'unread_count' => $this->getUnreadCount()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('Failed to fetch unread notifications')
            ], 500);
        }
    }

    // Helper function to get unread count
    private function getUnreadCount()
    {
        return Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }
}