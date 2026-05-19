<?php

namespace App\Notifications\lists;

use App\Models\Boardlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeleteListLabelNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Boardlist $list,
        public string $message = '',
        public $sender = null,
    )
    {}

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
            'toast_type'=> 'deletelabel',
            'action'    => 'label_remove',
            'list_slug' => $this->list->slug,
            'user'      => $this->sender->name,
            'message'   => 'Label is deleted for list `'.$this->list->title.'` by: '.$this->sender->name,
        ];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage ([
            'toast_type'=> 'deletelabel',
            'action'    => 'label_remove',
            'list_slug' => $this->list->slug,
            'user'      => $this->sender->name,
            'message'   => 'Label is deleted for list `'.$this->list->title.'` by: '.$this->sender->name,
        ]);
    }
}
