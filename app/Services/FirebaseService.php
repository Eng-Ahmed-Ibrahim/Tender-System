<?php

namespace App\Services;

use Kreait\Firebase\Messaging;
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
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        if (!empty($data)) {
            $message = $message->withData($data);
        }

        return $this->messaging->send($message);
    }

    public function sendMulticast(array $tokens, string $title, string $body, array $data = [])
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification);

        if (!empty($data)) {
            $message = $message->withData($data);
        }

        return $this->messaging->sendMulticast($message, $tokens);
    }
}
