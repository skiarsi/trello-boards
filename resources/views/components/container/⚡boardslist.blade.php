<?php

use Livewire\Component;
use App\Models\Board;
use Livewire\Attributes\On;

new class extends Component
{

    public $board;
    public $userRole;
    public $boardlist = [];

    public function mount($board)
    {
        $this->board = $board;
    }
};
?>

<div class="flex-1 h-full flex flex-col overflow-hidden">

    <livewire:board.header :board="$board" :userRole="$userRole" />



    <livewire:board.lists :userRole="$userRole" :board="$board" />

</div>
