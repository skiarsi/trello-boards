<?php

use Livewire\Component;
use Livewire\Attributes\On;


new class extends Component
{
    public $board;
    public $boardlists;

    #[On('board-updated')]
    public function mount(){

    }
};
?>

<div
    style="background-color:{{ $board->color }}"
    class="w-full h-full py-3 px-3 flex gap-3 justify-start items-start"
    >

    {{-- new list button --}}
    <livewire:lists.newlist :board="$board" />

    {{-- lists --}}
    @foreach ($this->boardlists as $list)
        <livewire:lists.main :list="$list" />
    @endforeach
</div>
