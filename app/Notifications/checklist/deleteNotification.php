<?php

namespace App\Notifications\checklist;

use App\Models\ChecklistItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class deleteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $userId,
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
        if ($notifiable->id === $this->userId) {
            return [];
        }
        return ['broadcast'];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type' => 'checklistitem-delete',
            'action'     => 'checklistitem-delete',
        ]);
    }
}
