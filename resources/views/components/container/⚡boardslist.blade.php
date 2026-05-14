<?php

use Livewire\Component;
use App\Models\Board;
use Livewire\Attributes\On;

new class extends Component
{

    public $board;
    public $userRole;
    public $boardlist = [];


    #[On('list-created')]
    public function loadlists()
    {
        $this->boardlist = $this->board->lists()->get();
    }



    public function mount($board)
    {
        $this->board = $board;
        $this->loadlists();
    }
};
?>

<div class="flex-1 h-full flex flex-col overflow-hidden">
    <livewire:board.header :board="$board" :userRole="$userRole" />


    <livewire:board.lists :board="$board" :boardlists="$boardlist" />

</div>
