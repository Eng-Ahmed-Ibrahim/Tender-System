<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;

class DeviceNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $deviceToken;

    public function __construct($title, $body, $deviceToken)
    {
        $this->title = $title;
        $this->body = $body;
        $this->deviceToken = $deviceToken;
    }

    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFcm($notifiable)
    {
        // Use Firebase Messaging service to send the notification
        $messaging = app('firebase.messaging');

        // Create the CloudMessage using the device token
        $message = CloudMessage::withTarget('token', $this->deviceToken)
            ->withNotification(FCMNotification::create($this->title, $this->body))
            ->withData(['extra_data' => 'extra_value']); // Optional data payload

        // Send the message to the device
        return $messaging->send($message);
    }
}
