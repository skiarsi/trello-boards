<?php

use Livewire\Component;

new class extends Component
{

    public $board;
};
?>

<div class="flex-1 h-full flex flex-col" style="background:{{ $board->color }}">
    <livewire:board.header :board="$board" />
</div>
