<?php

namespace App\Notifications\cards\labels;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NotificationDeletelabel extends Notification implements ShouldQueue
{
    use Queueable;

    public $userName;
    public $cardId;
    public $cardTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct($requestData, Card $card)
    {
        $this->userName = $requestData['user_name'] ?? 'Someone';
        $this->cardId = $card->id;
        $this->cardTitle = $card->title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type' => 'card-label-updated',
            'action'     => 'card-label-updated',
            'message'    => "Label on Card `{$this->cardTitle}` is deleted by `{$this->userName}`",
            'card_id'    => $this->cardId,
        ]);
    }
}
