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

    #[On('list-created')]
    public function refreshLists()
    {
        $this->boardlists = $this->board->lists()->get();
    }
};
?>

<div
    style="background-color:{{ $board->color }}"
    class="flex-1 h-full py-3 px-3 flex flex-row gap-3 items-start overflow-x-auto"
    >

    {{-- new list button --}}
    <livewire:lists.newlist :board="$board" />

    {{-- lists --}}
    @foreach ($this->boardlists as $list)
        <livewire:lists.main :list="$list" />
    @endforeach
</div>
