<?php

namespace App\Notifications\boards;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;


class BoardRemoveMemberNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    public $board;
    public $userId;
    public $wasPending;

    /**
     * Create a new notification instance.
     */
    public function __construct(Board $board, $userId, $wasPending, public $sender)
    {
        $this->board = $board;
        $this->userId = $userId;
        $this->wasPending = $wasPending;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
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
            'toast_type'=> 'removeMember',
            'board_id'  => $this->board->id,
            'user'      => $this->sender->name,
            'url'       => route('board', $this->board->slug),
            'message'   => 'You have been removed from board #'. $this->board->slug,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage {


        return new BroadcastMessage([
            'toast_type'=> 'removeMember',
            'board_id'  => $this->board->id,
            'board_slug'=> $this->board->slug,
            'url'       => route('board', $this->board->slug),
            'message'   => 'You have been removed from board: '. $this->board->slug,
            'was_pending' => $this->wasPending,
        ]);
    }
}
