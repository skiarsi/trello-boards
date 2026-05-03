<?php

use Livewire\Component;

new class extends Component
{
    public $list;
    public $cards = [];
    public function mount(){
        $this->list->load(['cards']);
    }
};
?>

<div class="w-full mb-1 flex flex-col gap-1 group">
    @foreach ($list->cards as $card)

        @if ($loop->first)
            <hr class="mt-2 opacity-0"/>
        @endif
        <div class="text-lg w-full py-1 rounded-md px-2 shadow cursor-pointer opacity-90 group-hover:opacity-100" style="background:{{ $card->color }}">
            {{ $card->title }}
        </div>
    @endforeach
</div>
