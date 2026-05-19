<?php

namespace App\Notifications\lists;

use App\Models\Boardlist;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Boardlist $list,
        public string $action
    )
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($notifiable->id === Auth::user()->id) {
            return ['broadcast'];
        }
        return ['broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'toast_type'=> 'updatelist',
            'action'    => $this->action,
            'message'   => 'list updated by: `'. Auth::user()->name
        ];
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'=> 'updatelist',
            'action'    => $this->action,
            'message'   => 'list updated by: `'. Auth::user()->name
        ]);
    }
}
