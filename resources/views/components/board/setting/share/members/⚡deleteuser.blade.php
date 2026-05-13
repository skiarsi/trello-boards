<?php

use Livewire\Component;
use App\Models\Board;
use App\Models\User;
use App\Notifications\BoardRemoveMemberNotification;

new class extends Component
{
    public $userId;
    public $boardId;

    // delete user from joining request
    public function deletependinguser($userId){
        $board = Board::find($this->boardId);


        // first reverb
        $invitedUser = User::find($userId);
        $invitedUser->notify(new BoardRemoveMemberNotification($board, $userId));


        // second update database
        $board->users()->updateExistingPivot($this->userId,[
            'status' => 'declined'
        ]);





        $this->dispatch('member-updated');
    }
};
?>

<x-heroicon-s-trash class="w-6 h-6 mt-1.5 cursor-pointer" wire:click="deletependinguser({{ $this->userId }})" wire:confirm="Are you sure?" />
