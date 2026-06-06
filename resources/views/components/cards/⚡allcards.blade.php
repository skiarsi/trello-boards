<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Boardlist;
use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

new class extends Component
{

    public Boardlist $list;
    public $board;
    public $userRole;
    public $cardlabels = [];

    public $checked = false;


    #[On('card-created')]
    #[On('card-updated')]
    public function refreshCards($listId)
    {
        if($listId === $this->list->id){
            $this->list = $this->list->fresh([
                                                'cards.labels',
                                                'cards.checklists.items'
                                            ]);
        }
    }

    public function mount(){
        $this->list = $this->list->load('cards.labels','cards.checklists.items');
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
                style="background:#fafafa; {{ $card->color ? 'border-top: 2rem solid '.$card->color.'' : '' }}">

                <div class="w-full flex items-start gap-0">
                    @if ($this->userRole === "owner")
                        <x-checkbox
                            wire:key="check-{{ $card->id }}"
                            x-model="isChecked"
                            class="self-start w-5 h-5 p-0.5 transition-all duration-300 hidden group-hover/card:block"
                            ::class="{ 'block!': isChecked }">
                        </x-checkbox>
                    @endif

                    <div class="flex-1 min-w-0 px-0">
                        <livewire:cards.onecard
                            wire:key="item-card-{{ $card->slug }}"
                            :card="$card"
                            :list="$this->list"
                            :userRole="$this->userRole" />

                        <livewire:cards.labels.view :card="$card" />
                    </div>


                </div>

            </div>
        @endforeach
    @endif


</div>
