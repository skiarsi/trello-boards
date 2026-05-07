<?php

use Livewire\Component;
use App\Models\Board;

new class extends Component
{
    public $userId;
    public $boardId;

    // delete user from joining request
    public function deletependinguser($userId){
        $board = Board::find($this->boardId);
        $board->users()->detach($this->userId);

        $this->dispatch('member-updated');
    }
};
?>

<x-heroicon-s-trash class="w-6 h-6 mt-1.5 cursor-pointer" wire:click="deletependinguser({{ $this->userId }})" wire:confirm="Are you sure?" />
