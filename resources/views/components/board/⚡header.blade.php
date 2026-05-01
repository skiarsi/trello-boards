<?php

use Livewire\Component;

new class extends Component
{
    public $board;
    public $userRole;

    public $title = '';



    public function mount(){
        $this->title = $this->board->title;
    }
};
?>

<div class="bg-gray-800/80 w-full py-2 flex justify-between px-4">

    {{-- board title --}}
    <livewire:board.setting.change-name :board="$board" wire:model="title" :userRole="$userRole" />

    {{-- board color --}}
    <livewire:board.settingmenu :board="$board" :userRole="$userRole" />

</div>
