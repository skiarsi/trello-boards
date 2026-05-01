<?php

use Livewire\Component;

new class extends Component
{

    public $board;
    public $boardlist=[];
    public $userRole;

    public function mount(){
        $this->boardlist = $this->board->lists()->get();
    }
};
?>

<div class="flex-1 h-full flex flex-col" style="background:{{ $board->color }}">
    <livewire:board.header :board="$board" :userRole="$userRole" />

    <livewire:board.lists :board="$board" :boardlists="$boardlist" />
</div>
