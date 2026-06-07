<?php

use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\comments\DeleteCommentNotification;

new class extends Component
{
    public $comment;
    public $userRole;
    public $list;


    public function deleteComment(){
        $this->comment->delete();

        $this->dispatch('comment_delete');

        Notification::send(
            $this->list->activeUsers()->get(),
            new DeleteCommentNotification(
                sender: Auth::user()
            )
        );

    }
};
?>

<div class="flex gap-3 bg-stone-100 p-2 group">
    <div data-tip="{{ $this->comment->user?->name }}" class="tooltip tooltip-right w-8 h-8 select-none text-white text-sm flex justify-center items-center rounded-full {{ $this->comment->id % 2 != 0 ? 'bg-red-900' : 'bg-red-700' }}">
        {{ ucfirst($this->comment->user?->name[0] ?? 'U') }}
    </div>
    <div class="flex-1 flex flex-col">
        <span class="text-sm text-start">{{ $this->comment->body }}</span>

        <div class="flex gap-3">
            <span class="text-xs text-start select-none flex flex-3">
                {{ $this->comment->created_at->diffForHumans() }}
            </span>

            @if ($this->comment->user_id === Auth::id() || $this->userRole === "owner")
                <span
                    wire:confirm="Are you sure, you want to delete this comment?"
                    wire:click="deleteComment"
                    class="text-xs text-gray-500 cursor-pointer hover:text-gray-700 opacity-0 group-hover:opacity-100">Delete</span>
            @endif
        </div>
    </div>
</div>
