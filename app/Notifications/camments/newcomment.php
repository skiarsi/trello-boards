<?php

namespace App\Notifications\camments;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newcomment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Card $card,
        public $message = '',
        public $sender = null
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($notifiable->id === $this->sender->id)
            return ['broadcast'];

        return ['database','broadcast'];
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
            'toast_type'  => 'comment-new',
            'action'      => 'comment-new',
            'card_id'     => $this->card->id,
            'card_body'   => $this->card->body,
            'message'     => 'New comment from '.$this->sender->name.' for card `'.$this->card->body.'` added',
        ];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'  => 'comment-new',
            'action'      => 'comment-new',
            'card_id'     => $this->card->id,
            'card_body'   => $this->card->body,
            'message'     => 'New comment from '.$this->sender->name.' for card `'.$this->card->body.'` added',
        ]);
    }
}
