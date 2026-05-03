<?php

use Livewire\Component;
use Livewire\Attributes\On;
use \App\Models\Board;

new class extends Component
{
    public $userboards = [];

    public function mount(){
        $this->loadBoards();
        $user = Auth::user();
        $this->userboards = Board::where('owner_id', $user->id)
                                ->orWhereHas('users', function($query) use ($user){
                                    $query->where('user_id', $user->id);
                                })
                                ->where('is_archive', false)
                                ->latest()
                                ->with(['labels'])
                                ->get();
    }


    #[On('board-created')]
    #[On('board-updated')]
    public function loadBoards(){
        $user = Auth::user();
        $this->userboards = Board::where('owner_id', $user->id)
                                ->orWhereHas('users', function($query) use ($user){
                                    $query->where('user_id', $user->id);
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
        <a href="{{ route("board",$board->slug) }}" wire:navigate class="w-full py-3 px-2 mb-1 rounded flex flex-col items-start cursor-pointer select-none group"
             style="background-color: {{ $board->color }}">

            {{-- if board is shared with current user add `shared` label --}}
            @if($board->owner_id !== Auth::id())
                <span class="text-[10px] bg-white/50 px-1.5 py-0.5 rounded uppercase">Shared</span>
            @endif

            <div class="flex flex-col w-full">
                <span class="font-medium text-gray-600 group-hover:text-gray-900">{{ $board->title }}</span>
                <livewire:board.label.labellist :labels="$board->labels" />
            </div>





        </a>
    @empty
        <p class="text-xs text-gray-500 text-center">No boards found.</p>
    @endforelse
</div>
