<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Board;

new class extends Component
{
    public $userboards = [];
    public int $refreshKey = 0;

    public function mount(){
        $this->loadAllBoards();
    }


    #[On('board-created')]
    #[On('board-updated')]
    public function loadAllBoards(){

        $this->reset('userboards');
        $this->refreshKey++;

        $user = Auth::user();

        $this->userboards = Board::where(function($query) use ($user) {
                $query->where('owner_id', $user->id)
                    ->orWhereHas('users', function($q) use ($user) {
                        $q->where('user_id', $user->id)
                          ->where('status', 'accepted');
                    });
            })
            ->where('is_archive', false)
            ->latest()
            ->with(['labels', 'users'])
            ->get();
    }
};
?>

<div class="w-full flex flex-col ">
    <div class="relative border-b border-gray-400 my-5">
        <span class="px-2 text-sm bg-stone-200 absolute left-2 -top-2 select-none">Boards</span>
    </div>

    @forelse ($userboards as $board)
        <a
            wire:key="board-item-{{ $board->id }}-{{ $refreshKey }}"
            href="{{ route("board",$board->slug) }}"
            wire:navigate
            class="w-full py-3 px-2 mb-1 rounded flex flex-col items-start cursor-pointer select-none group"
             style="background-color: {{ $board->color }}">

            {{-- if board is shared with current user add `shared` label --}}
            @if($board->owner_id !== Auth::id())
                <span class="text-[10px] bg-white/50 px-1.5 py-0.5 rounded uppercase">Shared</span>
            @endif

            <div class="flex flex-col w-full">
                <span class="font-medium text-gray-600 group-hover:text-gray-900">{{ $board->title }}</span>
                <livewire:board.labelmanagement.labels :labels="$board->labels" :board="$board" :wire:key="'labellist-'.$board->id.'-'.$refreshKey" />
            </div>





        </a>
    @empty
        <p class="text-xs text-gray-500 text-center">No boards found.</p>
    @endforelse
</div>
