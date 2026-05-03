<?php

use Livewire\Component;

new class extends Component
{
    public $users;
};
?>

<div class="w-fullselect-none border-t border-gray-400 flex flex-col pt-1">
    @foreach ($this->users as $user)
        <div class="flex gap-2 py-1 w-full">
            <div class="w-10 h-10 rounded-full overflow-hidden flex justify-center items-center align-middle border-2 border-gray-500 bg-stone-200 select-none">
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

            <div class="ms-auto me-0">
                <select
                    class="text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-blue-500 disabled:bg-stone-100"
                    {{-- wire:change="updateUserRole({{ $user->id }}, $event.target.value)" --}}

                    @if($user->id === Auth::id() || $user->pivot->role === 'owner') disabled @endif
                >
                    <option value="owner" {{ $user->pivot->role === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="editor" {{ $user->pivot->role === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="viewer" {{ $user->pivot->role === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </select>
            </div>
        </div>
    @endforeach
</div>
