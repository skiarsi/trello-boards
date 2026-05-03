<?php

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $board;

    public $title = '';

    #[Computed]
    public function userRole()
    {
        return $this->board->currentUserRole();
    }


    public function mount($board){
        $this->board = $board;
        $this->title = $this->board->title;
    }
};
?>

<div class="bg-gray-800/80 w-full py-2 flex justify-between px-4">

    {{-- board title --}}
    <livewire:board.setting.change-name :board="$board" wire:model="title" />

    <div class="flex gap-2">


        {{-- add/edit labels --}}
        <livewire:board.label.labelmodal :board="$board" />


        {{-- Owner can share board --}}
        @if ($this->userRole === "owner")
            <livewire:board.setting.share-board :board="$board" />
        @endif



        {{-- board setting menu --}}
        <livewire:board.settingmenu :board="$board" />


    </div>

</div>
