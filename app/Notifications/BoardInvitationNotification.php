<?php

namespace App\Notifications;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class BoardInvitationNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $board;
    /**
     * Create a new notification instance.
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'toast_type'=> 'inviteMember',
            'board_id'  => $this->board->id,
            'user'      => Auth::user()->name,
            'url'       => route('board',$this->board->slug),
            'message'   => "You have been invited to: ". $this->board->title
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage {
        return new BroadcastMessage([
            'toast_type'    => 'inviteMember',
            'board_id'      => $this->board->id,
            'board_slug'    => $this->board->slug,
            'url'           => route('board', $this->board->slug),
            'message'       => "You have been invited to board: " . $this->board->title,
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
}
