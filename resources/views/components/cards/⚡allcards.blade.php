<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Boardlist;
use App\Models\Card;

new class extends Component
{
    public $list;
    public $cards=[];
    public $board;
    public $userRole;

    public $checked = false;


    #[On('card-created')]
    public function refreshCards($listId)
    {
        if($listId === $this->list->id){
            $this->cards = Card::where('boardlists_id', $this->list->id)->get();
        }
    }

    public function mount(){
        $this->cards = Card::where('boardlists_id', $this->list->id)->get();
    }
};
?>

<div class="w-full flex flex-col gap-1 pb-3">
    @foreach ($this->cards as $card)
        <div
            wire:key="card-{{ $card->id }}"
            x-data="{ isChecked: false }"
            class="text-lg w-full py-1 rounded-md px-2 shadow cursor-pointer opacity-90 hover:opacity-100 flex group/card"
            style="background:{{ $card->color }}">
            @if ($this->userRole === "owner")
                <x-checkbox
                    wire:model="item4"
                    x-model="isChecked"
                    ::class="isChecked ? 'opacity-100 visible' : 'opacity-0 invisible group-hover/card:opacity-100 group-hover/card:visible'"
                    class="self-start w-4 h-4 p-0.5 mt-0.5 transition-all duration-300">
                </x-checkbox>
            @endif
            <span class="flex-1">{{ $card->title }}</span>
        </div>
    @endforeach
</div>
