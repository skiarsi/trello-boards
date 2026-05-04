<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Boardpage extends Component
{
    public Board $board;
    public $user;

    public function mount(Board $board)
    {
        if ($board->is_archive){
            abort(404);
        }

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
