<?php

namespace App\Notifications\comments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Card;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewcommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Card $card,
        public $message = '',
        public $sender = null
    ){}

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
            'comment_body'=> $this->card->title,
            'message'     => 'New comment from '.ucfirst($this->sender->name).' added to card `'.$this->card->title.'`',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'  => 'comment-new',
            'action'      => 'comment-new',
            'card_id'     => $this->card->id,
            'card_body'   => $this->card->body,
            'message'     => 'New comment from '.ucfirst($this->sender->name).' added to card `'.$this->card->title.'`',
        ]);
    }
}
