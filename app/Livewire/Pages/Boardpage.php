<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Livewire\Attributes\Title;
use Livewire\Component;

class Boardpage extends Component
{
    public Board $board;

    public function mount(Board $board)
    {
        $this->board = $board;
    }

    public function render()
    {
        return view('livewire.pages.boardpage',[
            'board' => $this->board
        ])->title($this->board->title);
    }
}
