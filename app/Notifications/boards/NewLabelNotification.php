<?php

namespace App\Notifications\boards;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewLabelNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Board $board,
        public string $message,
        public $sender = null
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
            'toast_type'  => 'board-newlabel',
            'action'      => 'board-newlabel',
            'board_id'    => $this->board->id,
            'board_slug'  => $this->board->slug,
            'board_title'  => $this->board->title,
            'message'     => 'New label for board `'.$this->board->title.'` added',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'  => 'board-newlabel',
            'action'      => 'board-newlabel',
            'board_id'    => $this->board->id,
            'board_slug'  => $this->board->slug,
            'board_title' => $this->board->title,
            'user'        => $this->sender->name,
            'message'     => 'New label for board `'.$this->board->title.'` added',
        ]);
    }
}
