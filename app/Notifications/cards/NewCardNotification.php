<?php

namespace App\Notifications\cards;

use App\Models\Boardlist;
use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewCardNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Boardlist $list,
        public Card $card,
        public string $message,
        public $sender = null

    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($notifiable->id === $this->sender->id) {
            return ['broadcast'];
        }
        return ['broadcast', 'database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'toast_type' => 'card-newcard',
            'action'     => 'card-newcard',
            'list_id'    => $this->list->id,
            'list_slug'  => $this->list->slug,
            'list_title' => $this->list->title,
            'card_title' => $this->card->title,
            'card_slug'  => $this->card->slug,
            'user'       => $this->sender->name,
            'message'    => 'New card `'.$this->card->title.'` for list `'.$this->list->title.'` added',
        ];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type' => 'card-newcard',
            'action'     => 'card-newcard',
            'list_id'    => $this->list->id,
            'list_slug'  => $this->list->slug,
            'list_title' => $this->list->title,
            'card_title' => $this->card->title,
            'card_slug'  => $this->card->slug,
            'user'       => $this->sender->name,
            'message'    => 'New card `'.$this->card->title.'` for list `'.$this->list->title.'` added',
        ]);
    }
}
