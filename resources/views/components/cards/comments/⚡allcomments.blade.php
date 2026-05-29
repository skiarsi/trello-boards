<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Card;
use App\Models\Comment;

new class extends Component
{

    public Card $card;
    public $comments;


    public function mount(Card $card){
        $this->card = $card;

        $this->comments = $card->comments;
    }

    // #[Computed(persist: true)]
    // public function comments()
    // {
    //     return $this->card->comments()->with('user')->orderBy('created_at', 'desc')->get();
    // }

    #[On('comment_added')]
    public function handleCommentAdded()
    {

    }
};
?>

<div class="w-full flex flex-col gap-1 px-3 max-h-85 overflow-auto min-h-100">
    @forelse ($this->comments as $comment)
        <div wire:key="comments-{{ $comment->id }}" class="flex gap-3 bg-stone-100 p-2">
            <div class=" w-8 h-8 select-none text-white text-sm flex justify-center items-center rounded-full {{ $loop->even ? 'bg-red-900' : 'bg-red-700' }}">
                {{-- {{ ucfirst($comment->user->name[0]) }} --}}
            </div>
            <div class="flex-1 flex flex-col">
                <span class="text-sm text-start">{{ $comment->body }}</span>
                <span class="text-xs text-start select-none cursor-pointer">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm italic">No Comment added</p>
    @endforelse
</div>
