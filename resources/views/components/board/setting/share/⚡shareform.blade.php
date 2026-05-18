<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;
use App\Notifications\boards\BoardInvitationNotification;

new class extends Component
{
    public $board;
    public $search = '';
    public $results = [];

    public function performSearch()
    {
        $this->validate([
            'search' => 'required|string|min:3',
        ], [
            'search.required' => 'Please enter a name or username.',
        ]);

        $cleanSearch = trim($this->search);
        $searchTerm = $cleanSearch;
        $isUsernameSearch = false;

        // check if search start with @
        if (str_starts_with($cleanSearch, '@')) {
            $searchTerm = ltrim($cleanSearch, '@'); // remove @ from string
            $isUsernameSearch = true;
        }

        if (strlen($searchTerm) < 3) {
            $this->results = [];
            return;
        }

        // take user ids that are member of board
        $existingUserIds = $this->board->users()
                                        ->wherePivotIn('status', ['pending', 'accepted', 'owner'])
                                        ->pluck('users.id')->toArray();

        $this->results = User::where(function($query) use ($searchTerm, $isUsernameSearch) {
                if ($isUsernameSearch) {
                    // just check username
                    // because user input @ in input
                    $query->where('username', 'like', $searchTerm . '%');
                } else {
                    // search between username and name
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('username', 'like', '%' . $searchTerm . '%');
                }
            })
            ->whereNotIn('id', $existingUserIds)
            ->take(5)
            ->get()
            ->toArray();

        $this->dispatch('search-completed');
    }

    public function inviteUser($userId)
    {
        $userId = (int) $userId;

        $this->board->users()->syncWithoutDetaching([
            $userId => [
                'status' => 'pending',
                'role' => 'viewer'
            ]
        ]);


        // reverb
        $invitedUser = User::find($userId);
        $invitedUser->notify(new BoardInvitationNotification($this->board));

        $this->search = '';
        $this->results = [];

        $this->dispatch('member-updated');
    }
};
?>

<div
    class="w-full flex flex-col pb-5"
    x-data="{ showModal: false }"
    @search-completed.window="showModal = true"
    @user-invited.window="showModal = false"
>
    {{-- Search Bar --}}
    <form wire:submit.prevent="performSearch" class="flex flex-col gap-1 w-full pt-8 relative">
        <div class="flex gap-1 w-full">
            <input
                type="text"
                wire:model="search"
                class="py-2 px-3 flex-1 border text-black text-lg @error('search') border-red-500 @else border-gray-400 @enderror focus:outline-none focus:border-sky-800"
                placeholder="User account or name"
            />
            <button type="submit" class="bg-sky-800 text-white text-lg px-8 hover:bg-sky-900 transition-colors">
                Search
            </button>
        </div>


        @error('search')
            <span class="text-red-500 text-sm font-light">{{ $message }}</span>
        @enderror
    </form>

    {{-- Popup Modal --}}
    <div
        x-show="showModal"

        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        x-cloak
    >
        <div
            @click.outside="showModal = false"
            class="bg-white w-full max-w-md rounded-lg shadow-2xl overflow-hidden"
        >
            <div class="flex justify-between items-center bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="font-bold text-gray-700">Search Results</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <div class="p-2 max-h-[400px] overflow-y-auto bg-white text-black">

                @if(count($results) > 0)
                    @foreach($results as $user)
                        <div
                            wire:key="user-invite-{{ $user['id'] }}"
                            class="flex items-center justify-between py-3 px-4 hover:bg-sky-50 border-b border-gray-100 last:border-0"
                        >
                            <div class="flex flex-col">
                                <span class="text-gray-900 font-semibold">{{ $user['name'] }}</span>
                                <span class="text-xs text-gray-500 italic">{{ '@'.$user['username'] }}</span>
                            </div>

                            <button
                                wire:click="inviteUser({{ $user['id'] }})"
                                wire:loading.attr="disabled"
                                type="button"
                                class="bg-sky-700 text-white px-4 py-1.5 rounded-md hover:bg-sky-800 transition-all text-xs font-bold"
                            >
                                Invite
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500">No users found for "{{ $search }}"</p>
                        <button type="button" @click="showModal = false" class="mt-4 text-sky-700 underline text-sm font-bold">Close and try again</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
