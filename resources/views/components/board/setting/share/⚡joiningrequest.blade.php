<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $board;

    #[On('member-updated')]
    public function refreshUsers()
    {
        $this->board->load('users');
    }
};
?>

<div class="tab-content bg-base-100 py-3">
    @foreach ($this->board->users as $user)
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
                        :wire:key="'delete-user-'.$user->id" />

                    <livewire:board.setting.share.members.updateuserrole
                        :board="$board"
                        :user="$user"
                        :wire:key="'update-role-' . $user->id . '-' . $user->pivot->role" />
                    {{-- <select
                        class="text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-blue-500 disabled:bg-stone-100"

                        @if($user->id === Auth::id() || $user->pivot->role === 'owner') disabled @endif
                    >
                        <option value="owner" {{ $user->pivot->role === 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="editor" {{ $user->pivot->role === 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="viewer" {{ $user->pivot->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                    </select> --}}
                </div>
            </div>
        @else

        @endif
    @endforeach
</div>
