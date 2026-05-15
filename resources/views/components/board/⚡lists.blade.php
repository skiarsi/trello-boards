<?php

use Livewire\Component;
use Livewire\Attributes\On;


new class extends Component
{
    public $board;
    public $boardlists;
    public $userRole;

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
    @if ($this->userRole !=="viewer")
        <livewire:lists.newlist :userRole="$userRole" :board="$board" />
    @endif

    {{-- lists --}}
    @foreach ($this->boardlists as $list)
        <livewire:lists.main :userRole="$userRole" :board="$this->board" :list="$list" wire:key="{{ 'list-'.$list->id }}" />
    @endforeach
</div>
