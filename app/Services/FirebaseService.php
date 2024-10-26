<?php

namespace App\Services;

use App\Models\User;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendNotification(string $token, string $title, string $body, array $data = [])
    {
        try {
            $notification = Notification::create($title, $body);

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);

            if (!empty($data)) {
                $message = $message->withData($data);
            }

            return $this->messaging->send($message);
        } catch (\Exception $e) {
            Log::error('Firebase notification error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendMulticast(array $tokens, string $title, string $body, array $data = [])
    {
        try {
            $notification = Notification::create($title, $body);

            $message = CloudMessage::new()
                ->withNotification($notification);

            if (!empty($data)) {
                $message = $message->withData($data);
            }

            return $this->messaging->sendMulticast($message, $tokens);
        } catch (\Exception $e) {
            \Log::error('Firebase multicast error: ' . $e->getMessage());
            throw $e;
        }
    }


    public function sendNotificationToAllDevices(User $user, string $title, string $body, array $data = [])
{
    $tokens = array_filter([$user->fcm_token, $user->web_fcm_token]);
    
    if (!empty($tokens)) {
        return $this->sendMulticast($tokens, $title, $body, $data);
    }
    
    return null;
}
}