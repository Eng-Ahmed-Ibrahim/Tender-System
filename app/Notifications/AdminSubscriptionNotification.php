<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminSubscriptionNotification extends Notification
{
    use Queueable;


    protected $subscription;
    protected $action; // 'created' or 'updated'


    public function __construct($subscription, $action)
    {
        $this->subscription = $subscription;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => ($this->action == 'created') 
                ? $this->subscription->customer->name. ' has new subscription.' 
                : $this->subscription->customer->name. ' has upgraded his plan.',

            'subscription_id' => $this->subscription->id,
            'customer_name' => $this->subscription->customer->name,
            'start_date' => $this->subscription->start_date,
            'end_date' => $this->subscription->end_date,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
