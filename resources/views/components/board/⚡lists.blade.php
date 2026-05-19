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
        $this->refreshLists();
    }

    #[On('list-created')]
    public function refreshLists()
    {
        $this->boardlists = $this->board->lists()->get();
    }
};
?>

<div
    style="background-color:{{ $this->board->color }}"
    class="flex-1 h-full py-3 px-3 flex flex-row gap-3 items-start overflow-x-auto" >


    {{-- lists --}}
    @foreach ($this->boardlists as $list)
        <livewire:lists.main
                    :userRole="$userRole"
                    :board="$this->board"
                    :list="$list"
                    wire:key="{{ 'list-'.$list->id }}" />
    @endforeach


    {{-- new list button --}}
    @if ($this->userRole !=="viewer")
        <livewire:lists.newlist :userRole="$userRole" :board="$board" />
    @endif
</div>
