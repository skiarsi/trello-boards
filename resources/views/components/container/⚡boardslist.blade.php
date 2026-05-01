<?php

use Livewire\Component;

new class extends Component
{

    public $board;
    public $boardlist=[];

    public function mount(){
        $this->boardlist = $this->board->lists()->get();
    }
};
?>

<div class="flex-1 h-full flex flex-col" style="background:{{ $board->color }}">
    <livewire:board.header :board="$board" />

    <livewire:board.lists :board="$board" :boardlists="$boardlist" />
</div>
