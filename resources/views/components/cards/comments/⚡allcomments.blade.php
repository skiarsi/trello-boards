<?php

use Livewire\Component;
use App\Models\Card;

new class extends Component
{

    public Card $card;
    public $comments;

    public function loadcomments(){
        $this->comments = $this->card->comments;
    }

    public function mount(Card $card){
        $this->card = $card;
        $this->loadcomments();
    }
};
?>

<div class="w-full flex flex-col gap-1 px-3">
    @forelse ($comments as $comment)
        {{ $comment->body }}
    @empty
        <p class="text-gray-500 text-sm italic">No Comment added</p>
    @endforelse
</div>
