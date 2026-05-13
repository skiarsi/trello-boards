<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;


new class extends Component
{
    public bool   $show = false;

    public string $message = '';
    public string $url = '';
    public string $type = 'inviteMember';
    public string $board_slug = '';
    public string $board_id = '';
    public string $was_pending = '';


    #[On("show_toast")]
    public function showToest($type, $message, $board_slug, $board_id , $url ='', $was_pending ='' ){

        if ($type === 'removeMember' && $was_pending !== "accepted") {

            $user = Auth::user();
            $board = Board::where('slug', $board_slug)->first();

            $member = $board->users()
                            ->where('user_id', $user->id)
                            ->first();


            if ( $member && in_array($member->pivot->status, ['pending', 'declined'])) {
                return;
            }
        }


        $this->type = $type;
        $this->message = $message;
        $this->url = $url;
        $this->board_slug = $board_slug;
        $this->board_id = $board_id;



        $this->show = true;
    }

    // close toast
    public function dismiss()
    {
        $this->show = false;
    }


    // user accept/reject joining request
    #[On('invitation-response')]
    public function responeTojoin($board, $response){

        $user = Auth::user();
        $board = Board::where('id', $board)->first();

        if(!$board) return;

        $member = $board->users()->where('user_id', $user->id)->wherePivot('status','pending')->first();

        if(!$member) return;

        $board->users()->updateExistingPivot($user->id,[
            'status' => $response
        ]);

        $this->show = false;

        // send dispatches for update view
        // for board list
        $this->dispatch('board-updated');

        // for member lists
        $this->dispatch('member-updated');
    }

};
?>

<div class="relative w-full h-full">


    @if ($show)
        @php
            $color = match($type) {
                'inviteMember' => 'bg-green-600',
                'removeMember' => 'bg-red-600',
                default => 'bg-gray-600',
            };
        @endphp
        <div
            class="w-72 z-99 py-4 px-5 rounded-xl {{ $color }} text-white absolute"
            >
                <span class="absolute right-4 top-1 font-bold text-white text-3xl cursor-pointer" wire:click="dismiss()">&times;</span>
                <p class="text-sm mb-4 w-10/12 font-bold">{{ $message }}</p>

                {{-- @if ($type === 'inviteMember')
                    <p class="text-[1rem] flex gap-3">
                        <span
                            class="cursor-pointer py-0.5 px-4 bg-white text-black text-sm font-bold"
                            wire:click="responeTojoin('{{ $board_id }}', 'accepted')">Accept</span>
                        <span
                            class="cursor-pointer py-0.5 px-4 text-white text-sm font-bold"
                            wire:click="responeTojoin('{{ $board_id }}', 'declined')">Reject</span>
                    </p>
                @endif --}}
        </div>
    @endif
</div>
