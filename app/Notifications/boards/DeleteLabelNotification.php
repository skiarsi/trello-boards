<?php

namespace App\Notifications\boards;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class DeleteLabelNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Board $board,
        public string $label,
        public string $message
    )
    {}

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
            'toast_type'  => 'board-deletelabel',
            'action'      => 'board-deletelabel',
            'board_id'    => $this->board->id,
            'board_slug'  => $this->board->slug,
            'board_title' => $this->board->title,
            'message'     => 'Label `'.$this->label.'` for board `'.$this->board->title.'` is deleted',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'toast_type'  => 'board-deletelabel',
            'action'      => 'board-deletelabel',
            'board_id'    => $this->board->id,
            'board_slug'  => $this->board->slug,
            'board_title' => $this->board->title,
            'user'        => Auth::user()->name,
            'message'     => 'Label `'.$this->label.'` for board `'.$this->board->title.'` is deleted',
        ]);
    }
}
