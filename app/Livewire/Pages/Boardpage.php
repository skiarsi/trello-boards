<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class Boardpage extends Component
{
    public Board $board;
    public $user;

    public function mount(Board $board)
    {
        $this->board = $board;
    }

    public function render()
    {
        return view('livewire.pages.boardpage',[
            'board' => $this->board,
            'userRole'  => $this->board->currentUserRole()
        ])->title($this->board->title);
    }
}
