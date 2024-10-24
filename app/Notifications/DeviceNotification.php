<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
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

    // Specify the channels through which the notification will be sent
    public function via($notifiable)
    {
        return [FcmChannel::class]; // Use your custom FCM channel
    }

    // Build the FCM message
    public function toFcm($notifiable)
    {
        return CloudMessage::withTarget('token', $this->deviceToken)
            ->withNotification(FCMNotification::create($this->title, $this->body))
            ->withData(['extra_data' => 'extra_value']); // Optional data payload
    }
}
