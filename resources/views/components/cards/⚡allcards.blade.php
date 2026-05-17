<?php

use Livewire\Component;

new class extends Component
{
    public $list;
    public $cards = [];
};
?>

<div class="w-full flex flex-col gap-1 group pb-3">
    @foreach ($list->cards as $card)
        <div class="text-lg w-full py-1 rounded-md px-2 shadow cursor-pointer opacity-90 group-hover:opacity-100" style="background:{{ $card->color }}">
            {{ $card->title }}
        </div>
    @endforeach
</div>
