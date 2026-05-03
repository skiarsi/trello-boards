<?php

use Livewire\Component;
use App\Models\Board;

new class extends Component
{

    public Board $board;
    public $boardlist = [];

    public function mount($board){
        $this->board = $board;
        $this->boardlist = $this->board->lists()->get();
    }
};
?>

<div class="flex-1 h-full flex flex-col" style="background:{{ $board->color }}">
    <livewire:board.header :board="$board" />


    <livewire:board.lists :board="$board" :boardlists="$boardlist" />
</div>
