<?php

namespace App\Notifications\checklist;

use App\Models\Card;
use App\Models\Checklist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewChecklistNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Checklist $cheklist,
        public Card $card,
        public $userId,
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($notifiable->id === $this->userId) {
            return [];
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
            'toast_type'    => 'new-checklist',
            'action'        => 'new-checklist',
            'checklistId'   => $this->cheklist->id,
            'checklistTitle'=> $this->cheklist->title,
            'message'       => 'New Checklist in `'.$this->card->title.'` Card'
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'    => 'new-checklist',
            'action'        => 'new-checklist',
            'checklistId'   => $this->cheklist->id,
            'checklistTitle'=> $this->cheklist->title,
            'message'       => 'New Checklist in `'.$this->card.'` Card'
        ]);
    }
}
