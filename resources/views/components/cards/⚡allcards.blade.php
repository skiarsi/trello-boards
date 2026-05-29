<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Boardlist;
use App\Models\Card;

new class extends Component
{

    public Boardlist $list;
    public $cards=[];
    public $board;
    public $userRole;
    public $cardlabels = [];

    public $checked = false;


    #[On('card-created')]
    public function refreshCards($listId)
    {
        if($listId === $this->list->id){
            $this->list = $this->list->fresh(['cards.labels']);
        }
    }

    public function mount(){
        $this->list = $this->list->load('cards.labels');
    }

    public function loadcardlabels(){

    }
};
?>

<div class="w-full flex flex-col gap-1 pb-3">
    @if ($this->list->cards->count() > 0)
        <hr class="border border-gray-300 mx-auto mt-3 mb-2 w-10/12" />
        @foreach ($this->list->cards as $card)
            <div
                wire:key="card-{{ $card->id }}"
                x-data="{ isChecked: false }"
                class="text-lg w-full py-1 rounded-md px-2 shadow cursor-pointer opacity-90 hover:opacity-100 flex flex-col group/card"
                style="background:#fafafa; {{ $card->color ? 'border-top: 2rem solid '.$card->color.'' : ''  }}">

                <div class="w-full flex ">
                    @if ($this->userRole === "owner")
                        <x-checkbox
                            wire:key="check-{{ $card->id }}"
                            wire:model="item4"
                            x-model="isChecked"
                            ::class="isChecked ? 'opacity-100 visible' : 'opacity-0 invisible group-hover/card:opacity-100 group-hover/card:visible'"
                            class="self-start w-4 h-4 p-0.5 mt-0.5 transition-all duration-300">
                        </x-checkbox>
                    @endif

                    @include('components.cards.onecard', ['card' => $card, 'list'=>$this->list, 'userRole'=>$this->userRole])
                </div>
                <livewire:cards.labels.view :card="$card" />
            </div>
        @endforeach
    @endif


</div>
