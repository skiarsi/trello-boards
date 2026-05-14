<?php

namespace App\Notifications\lists;

use App\Models\Board;
use App\Models\Boardlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateNewNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Board $board,
        public Boardlist $list,
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
        return ['broadcast','database'];
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
            'toast_type'=> 'createlist',
            'action'    => 'create_list',
            'list_slug' => $this->list->slug,
            'board_slug' => $this->board->slug,
            'message'   => 'List `<strong>'.$this->list->title.'</strong>` for board `<strong>'.$this->board->title.'<strong>` created',
        ];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage ([
            'toast_type'=> 'createlist',
            'action'    => 'create_list',
            'list_id'   => $this->list->id,
            'list_slug' => $this->list->slug,
            'board_slug' => $this->board->slug,
            'message'   => 'New list for board `'.$this->board->slug.'` created',
        ]);
    }
}
