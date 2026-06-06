<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $list;
    public $card;
    public $userRole;

    #[On('card-label-updated-{card.id}')]
    #[On('card-date-updated-{card.id}')]
    #[On('card-updated')]
    public function cardRefresh($listId = null){
        $this->card = $this->card->fresh();
    }

};
?>

<div class="w-full" >

    <div onclick="document.getElementById('modal-{{ $this->card->id }}').showModal()" class="flex-1 block select-none">
        @if ($this->card->due_date)
            @if ($this->card->due_date->isPast() || $this->card->due_date->isToday())
                <div class="flex gap-1 items-start">
                    <x-icon name="clock" class="h-8 text-red-800" />
                    <div class="flex flex-col">
                        <span class="">{{ Str::limit($this->card->title, 16) }}</span>
                        <span class="italic text-xs text-red-500 -mt-1">Due date</span>
                    </div>
                </div>
            @elseif ($card->due_date->isTomorrow())
                <div class="flex gap-1 items-start">
                    <x-icon name="clock" class="h-8 text-yellow-600" />
                    <div class="flex flex-col">
                        <span class="">{{ Str::limit($this->card->title, 16) }}</span>
                        <span class="italic text-xs text-yellow-600 -mt-1">Due date is tomorrow</span>
                    </div>
                </div>
            @else
                <div class="flex gap-1 items-center">
                    <x-icon name="clock" class="h-5" />
                    <span class="">{{ Str::limit($this->card->title, 16) }}</span>
                </div>
            @endif
        @else
            <span class="">{{ Str::limit($this->card->title, 16) }}</span>
        @endif
    </div>


    <dialog id="modal-{{ $this->card->id }}" class="modal cursor-default">

        <div class="modal-box w-11/12 max-w-5xl" style="background:#fafafa; {{ $this->card->color ? 'border-top: 2rem solid '.$this->card->color.'' : ''  }}" >
            <div class="flex justify-between w-full border-b border-gray-200 overflow-hidden">
                <h3 class="text-xl font-bold">{{ $this->card->title }}</h3>
                <span onclick="document.getElementById('modal-{{ $this->card->id }}').close()"
                        class="py-0 -mt-4 text-5xl font-extralight text-gray-700 cursor-pointer select-none hover:text-black">&times;</span>
            </div>


            <div class="flex w-full">
                <div class="flex-1 py-3 px-2">
                    @if ($userRole !== 'viewer')
                        <livewire:cards.content.bar :userRole="$userRole" :card="$this->card" :list="$this->list" />
                    @endif
                    <livewire:cards.labels.manage :list="$this->list" :card="$this->card" :userRole="$userRole" />


                    <livewire:cards.dates.main :card="$this->card" />

                    <livewire:cards.checklist.main :list="$this->list" :card="$this->card" :userRole="$userRole" />

                    <livewire:cards.content.description :card="$this->card" :list="$this->list" />
                </div>
                <div class="w-5/12 py-3 border-l border-gray-200">
                    <livewire:cards.comments.newcomment :card="$this->card" :list="$this->list" />
                    {{-- <livewire:cards.comments.allcomments :card="$this->card" /> --}}
                </div>
            </div>
        </div>
    </dialog>
</div>
