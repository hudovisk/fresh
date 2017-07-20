<?php

namespace App\Notifications;

use App\Models\Advertisement;
use App\Channels\FCMMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertisementsNotification extends Notification
{
    use Queueable;

    private $advertisement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Advertisement $notice)
    {
        $this->advertisement = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [\App\Channels\FCMChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toFCM($notifieable = null) {
        return (new FCMMessage)
                    ->title($this->advertisement->title)
                    ->message($this->advertisement->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
