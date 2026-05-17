<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $board;
    public $users;


    public function mount()
    {
        $this->users = $this->board->users;
    }

    #[On('userlists-updated')]
    #[On('member-updated')]
    public function refreshUsers()
    {
        $this->board->load('users');
        $this->users = $this->board->users;
    }
};
?>

<div class="tab-content bg-base-100 py-3">
    @foreach ($this->users as $user)
        @if ($user->pivot->status === "pending")
            <div class="flex gap-3 py-1 w-full" wire:key="user-{{ $user->id }}">
                <div class="w-8 h-8 mt-1.5 rounded-full overflow-hidden flex justify-center items-center align-middle border-2 border-gray-500 bg-stone-200 select-none">
                    {{ mb_strtoupper($user->name[0], "UTF-8") }}
                </div>
                <div class="flex-1 leading-tight pt-0.5">
                    <p class="text-md m-0">
                        {{ strtok($user->name," ") }}
                        @if ($user->id === Auth::id())
                            (You)
                        @endif
                    </p>
                    <p class="m-0 text-gray-500 text-xs">
                        <span class="text-gray-700">{{ '@'.$user->username }}</span> |
                        {{ ucfirst($user->pivot->role) }}
                    </p>
                </div>

                <div class="ms-auto me-0 flex gap-3">

                    <livewire:board.setting.share.members.deleteuser
                        :userId="$user->id"
                        :boardId="$board->id"
                        wire:key="delete-user-{{ $user->id }}" />

                    <livewire:board.setting.share.members.updateuserrole
                        :board="$board"
                        :user="$user"
                        wire:key="update-role-{{ $user->id }} - {{ $user->pivot->role }}" />
                </div>
            </div>
        @else

        @endif
    @endforeach

    {{-- <hr class="my-2 border border-gray-200" />

    <div class="flex gap-2 cursor-pointer select-none " wire:click="$dispatch('userlists-updated')">
        <x-heroicon-o-arrow-path-rounded-square class="w-6 h-6 mt-0.5 text-gray-700" />
        <span class=" text-gray-700 py-0.5 pe-2 text-md">refresh users</span>
    </div> --}}
</div>
