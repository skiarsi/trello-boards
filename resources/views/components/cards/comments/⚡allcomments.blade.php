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
    public $userRole;
    public $list;


    public function mount(Card $card){
        // $this->card = $card;

        $this->loadComments();
    }

    public function loadComments(){
        $this->comments = $this->card->comments()->with('user')->latest()->get();
    }

    #[On('comment_added')]
    #[On('comment_delete')]
    public function handleCommentAdded()
    {
        $this->loadComments();
    }
};
?>

<div class="w-full flex flex-col gap-1 px-3 max-h-85 overflow-auto min-h-100">
    @forelse ($this->comments as $comment)
        <livewire:cards.comments.oncomment
                :comment="$comment"
                :userRole="$this->userRole"
                wire:key="comment-{{ $comment->id }}"
                :list="$this->list" />
    @empty
        <p class="text-gray-500 text-sm italic">No Comment added</p>
    @endforelse
</div>
