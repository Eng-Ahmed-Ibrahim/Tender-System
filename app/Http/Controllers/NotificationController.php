<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\DB;

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
        if(auth()->user()->role="admin_company")
        {
            $users = User::select('id', 'name', 'email')->where('company_id',auth()->user()->company_id)->get();

        }else{

            $users = User::select('id', 'name', 'email')->get();

        }

        return view('backend.notifications.create', compact('users'));
    }

    // Send notification to selected users
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'recipient_type' => 'required|in:specific,companies,all',
            'users' => 'required_if:recipient_type,specific|array',
            'users.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);
    
        try {
            DB::beginTransaction();
    
            // Determine recipients based on recipient type
            $users = collect();
            
            switch ($request->recipient_type) {
                case 'specific':
                    $users = User::whereIn('id', $request->users)->get();
                    break;
                
                case 'companies':
                    $users = User::where('role', 'admin_company')
                                ->where('status', 'active')
                                ->get();
                    break;
                
                case 'all':
                    $users = User::where('is_active', 'active')->get();
                    break;
            }
    
            $successCount = 0;
            $failedCount = 0;
            $errors = [];
    
            foreach ($users as $user) {
                try {
                    // Create notification record
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => $request->title,
                        'body' => $request->body,
                        'type' => 'general', // You can add different types if needed
                        'data' => json_encode([
                            'sender' => auth()->user()->name,
                            'sent_at' => now()->toDateTimeString(),
                        ]),
                        'read_at' => null,
                    ]);
    
                    // Send to Firebase
                    $this->firebaseService->sendNotificationToAllDevices(
                        $user,
                        $request->title,
                        $request->body
                    );
    
                    $successCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    $errors[] = "Failed for user {$user->email}: {$e->getMessage()}";
                    \Log::error("Notification failed for user {$user->id}: " . $e->getMessage());
                    continue; // Continue with next user even if one fails
                }
            }
    
            DB::commit();
    
            $message = "{{__('Successfully sent {$successCount} notifications.')}}";
            if ($failedCount > 0) {
                $message .= "{{__('Failed to send {$failedCount} notifications.')}}";
            }
    
            if (!empty($errors)) {
                \Log::error('Notification Errors:', $errors);
            }
    
            return redirect()->route('notifications.create')
                ->with('success', $message)
                ->with('errors', $errors); 
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Notification system error: ' . $e->getMessage());
            
            return redirect()->route('notifications.create')
                ->with('error', __('System error while sending notifications. Please try again.'));
        }
    }
    

    private function sendNotificationsInChunks($users, $title, $body, $chunkSize = 500)
    {
        $users->chunk($chunkSize)->each(function ($chunk) use ($title, $body) {
            foreach ($chunk as $user) {
                try {
                    // Create notification record
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => $title,
                        'body' => $body,
                        'read_at' => null,
                    ]);
    
                    // Send to Firebase
                    $this->firebaseService->sendNotificationToAllDevices(
                        $user,
                        $title,
                        $body
                    );
                } catch (\Exception $e) {
                    \Log::error("Chunked notification failed for user {$user->id}: " . $e->getMessage());
                    continue;
                }
            }
        });
    }

    // List all sent notifications
    public function index()
    {
        $notifications = Notification::with('user')
                                   ->latest()
                                   ->paginate(10);
                                   
        return view('backend.notifications.index', compact('notifications'));
    }

    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $user = auth()->user(); // Assuming user is authenticate
        $user->update(['fcm_token' => $request->token]); // or save token in another way

        return response()->json(['message' => __('Token stored successfully')]);
    }
}


