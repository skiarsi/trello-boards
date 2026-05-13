<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

new class extends Component
{
    public $board;
    public $userRole;

    public $title = '';



    public function mount($board){
        $this->board = $board;
        $this->boardTitle();
    }

    #[On('board-updated')]
    public function boardTitle(){
        $this->title = $this->board->title;
    }
};
?>

<div class="bg-gray-800/80 w-full py-2 flex justify-between px-4">

    {{-- board title --}}
    <livewire:board.setting.change-name
                    :userRole="$userRole"
                    :board="$board"
                    wire:model="title" />

    <div class="flex gap-2">


        {{-- add/edit labels --}}
        <livewire:board.labelmanagement.modal
                    :board="$board" />


        {{-- Owner can share board --}}
        @if ($this->userRole === "owner")
            <livewire:board.setting.share-board :board="$board" />
        @endif



        @if ($this->userRole !== "viewer")
            {{-- board setting menu --}}
            <livewire:board.settingmenu
                            :userRole="$userRole"
                            :board="$board" />
        @endif

    </div>

</div>
