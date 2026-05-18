<?php

use Livewire\Component;
use App\Models\Board;
use App\Models\User;
use App\Notifications\boards\BoardRemoveMemberNotification;

new class extends Component
{
    public $userId;
    public $boardId;

    // delete user from joining request
    public function deletependinguser($userId){
        $board = Board::find($this->boardId);


        // 1. read status
        $member = $board->users()->where('user_id', $userId)->first();
        $wasPending = $member?->pivot->status;

        // 2. reverb
        $invitedUser = User::find($userId);
        $invitedUser->notify(new BoardRemoveMemberNotification($board, $userId, $wasPending));


        // 3. update database
        $board->users()->updateExistingPivot($userId,[
            'status' => 'declined'
        ]);


        $this->dispatch('member-updated');
    }
};
?>

<x-heroicon-s-trash class="w-6 h-6 mt-1.5 cursor-pointer" wire:click="deletependinguser({{ $this->userId }})" wire:confirm="Are you sure?" />
