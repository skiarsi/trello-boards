<?php

namespace App\Notifications\cards;

use App\Models\Boardlist;
use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewCardNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Boardlist $list,
        public Card $card,
        public string $message,

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
        if ($notifiable->id === Auth::user()->id) {
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
            'user'       => Auth::user()->name,
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
            'user'       => Auth::user()->id,
            'message'    => 'New card `'.$this->card->title.'` for list `'.$this->list->title.'` added',
        ]);
    }
}
