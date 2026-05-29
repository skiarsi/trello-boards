<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Boardpage extends Component
{
    public Board $board;
    public $user;

    protected $currentBoardMember;

    public function mount(Board $board)
    {
        if ($board->is_archive){
            abort(404);
        }

        $this->board = $board;
    }

    public function boot(){
        $this->user = Auth::user();

        if ($this->board && $this->board->owner_id !== $this->user->id) {
            $this->currentBoardMember = $this->board->users()
                        ->where('user_id', $this->user->id)
                        ->first();

            if (!$this->currentBoardMember || $this->currentBoardMember->pivot->status !== 'accepted') {
                $this->redirect(route('index'));
            }
        }
    }

    public function render()
    {
        $userRole = null;

        if ($this->board->owner_id === Auth::id()) {
            $userRole = 'owner';
        } elseif ($this->currentBoardMember) {
            $userRole = $this->currentBoardMember->pivot->role;
        }

        return view('livewire.pages.boardpage',[
            'board' => $this->board,
            'userRole'  => $userRole
        ])->title($this->board->title);
    }
}
