<?php

namespace App\Livewire\Pages;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;


#[Layout('layouts.app')]
class Boardpage extends Component
{
    public Board $board;
    public $user;

    public function boot(){
        $user = Auth::user();

        if ($this->board && $this->board->owner_id !== $user->id) {
            $member = $this->board->users()
                        ->where('user_id', $user->id)
                        ->first();

            if (!$member || $member->pivot->status !== 'accepted') {
                $this->redirect(route('index'));
            }
        }
    }

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
