<?php

namespace App\Notifications\Page;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceChangesEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array
     */
    private array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $notificationData = [])
    {
        $this->data = $notificationData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello, '.$user->email)
            ->line('Price on the advertisement that you have subscribed has been updated.')
            ->line('Advertisement URL: '.($this->data['url'] ?? ''))
            ->line('Previous price: '.(
                round(($this->data['previous_price'] ?? 0) / 100, 2)
            ))
            ->line('New price: '.(
                round(($this->data['new_price'] ?? 0) / 100, 2)
            ))
            ->line('Thank you for using our service!');
    }
}
