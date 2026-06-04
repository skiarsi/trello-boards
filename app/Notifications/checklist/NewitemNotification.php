<?php

namespace App\Notifications\checklist;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewitemNotification extends Notification implements ShouldQueue
{
    // use Queueable;




    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $username,
        public $userId,
        public ChecklistItem $checklistitem,
        public string $checklisttitle,
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
            'toast_type'    => 'new-checklist-item',
            'action'        => 'new-checklist-item',
            'item_id'       => $this->checklistitem->id,
            'item_title'    => $this->checklistitem->title,
            'user_name'     => $this->username,
            'cheklisttitle' => $this->checklisttitle,
            'message'       => 'New Item in `'.$this->checklisttitle.'`: `'.$this->checklistitem->title.'`'
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type' => 'checklistitem-newitem',
            'action'     => 'checklistitem-newitem',
            'item_id'    => $this->checklistitem->id,
            'item_title' => $this->checklistitem->title,
            'user_name'     => $this->username,
            'cheklisttitle' => $this->checklisttitle,
            'message'       => 'New Item in `'.$this->checklisttitle.'`: `'.$this->checklistitem->title.'`'
        ]);
    }
}
