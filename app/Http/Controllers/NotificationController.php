<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    // Show form to send notification
    public function create()
    {
        $users = User::select('id', 'name', 'email')->get();
        return view('backend.notifications.create', compact('users'));
    }

    // Send notification to selected users
    public function store(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);
    
        try {
            foreach ($request->users as $userId) {
                $user = User::find($userId);
                
                // Create notification record
                Notification::create([
                    'user_id' => $userId,
                    'title' => $request->title,
                    'body' => $request->body,
                ]);
    
                // Send to both mobile and web if tokens exist
                $this->firebaseService->sendNotificationToAllDevices(
                    $user,
                    $request->title,
                    $request->body
                );
            }
    
            return redirect()->route('notifications.create')
                           ->with('success', 'Notifications sent successfully');
        } catch (\Exception $e) {
            return redirect()->route('notifications.create')
                           ->with('error', 'Failed to send notifications: ' . $e->getMessage());
        }
    }

    // List all sent notifications
    public function index()
    {
        $notifications = Notification::with('user')
                                   ->latest()
                                   ->paginate(10);
                                   
        return view('backend.notifications.index', compact('notifications'));
    }
}
