<?php

namespace App\Notifications;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class BoardUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Board $board,
        public string $action,  // 'color_change' , 'title_changed', 'archived'
        public string $message
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


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'  => 'boardUpdate',
            'action'      => $this->action,
            'board_id'    => $this->board->id,
            'board_slug'  => $this->board->slug,
            'message'     => $this->message,
            'url'         => route('board', $this->board->slug),
        ]);
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
            'toast_type'=> 'boardUpdate',
            'board_id'  => $this->board->id,
            'user'      => Auth::user()->name,
            'url'       => route('board', $this->board->slug),
            'message'   => 'Board updated by '.Auth::user()->name.' - '. $this->action,
        ];
    }
}
