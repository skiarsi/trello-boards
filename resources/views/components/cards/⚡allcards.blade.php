<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $list;
    public $userRole;
    public $cards = [];

    public $checked = false;

    #[On('card-created')]
    public function mount(){

    }
};
?>

<div class="w-full flex flex-col gap-1 group pb-3">
    @foreach ($list->cards as $card)
        <div
            x-data="{ isChecked: false }"
            class="text-lg w-full py-1 rounded-md px-2 shadow cursor-pointer opacity-90 group-hover:opacity-100 flex flex-3 group"
            style="background:{{ $card->color }}">
            @if ($this->userRole === "owner")
                <x-checkbox
                    wire:model="item4"
                    x-model="isChecked"
                    ::class="isChecked ? 'opacity-100 visible' : 'opacity-0 invisible group-hover:opacity-100 group-hover:visible'"
                    class="self-start w-4 h-4 p-0.5 mt-0.5 transition-all duration-300">
                </x-checkbox>
            @endif
            <span class="flex-1">{{ $card->title }}</span>
        </div>
    @endforeach
</div>
