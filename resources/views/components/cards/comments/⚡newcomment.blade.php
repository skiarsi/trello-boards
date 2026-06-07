<?php

use Livewire\Component;
use App\Models\Card;

use App\Notifications\comments\NewcommentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $list;
    public Card $card;

    public $commenttext='';

    public function newComment(){

        $this->validate([
            'commenttext' => 'required|min:2'
        ]);

        $newcomment = $this->card->comments()->create([
            'body'  => $this->commenttext,
            'user_id' => auth()->user()->id
        ]);

        $this->dispatch('comment_added');

        Notification::send(
            $this->list->activeUsers()->get(),
            new NewcommentNotification(
                card: $this->card,
                sender: Auth::user()
            )
        );

        $this->commenttext = '';
    }
};
?>

<div class="px-3 w-full">
    <h1 class="text-md font-bold text-gray-800 select-none">Comments and activity</h1>

    <input
        type="text" class="input outline-0 w-full focus:border-gray-200 mt-4"
        placeholder="Add comment..."
        wire:model = "commenttext"
        wire:keydown.enter="newComment" />

    @error('commenttext')
        <span class="text-red-700 italic text-xs">{{ $message }}</span>
    @enderror


    <hr class="mt-3 mb-2 mx-auto w-10/12 border border-gray-200" />
</div>
