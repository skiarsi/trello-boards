<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Board;

new class extends Component
{
    public int $unreadCount = 0;


    public function mount(){
        $this->loadCount();
    }



    #[On('show_toast')]
    #[On('board-updated')]
    #[On('list-created')]
    public function loadCount(){
        $this->unreadCount = auth()->user()
                                   ->unreadNotifications()
                                   ->count();
    }

    public function markAllAsRead(){
        auth()->user()->unreadNotifications->markAsRead();
        $this->unreadCount = 0;
    }

    public function markAsRead($notificationId){
        $notification = auth()->user()->notifications()->find($notificationId);
        $notification->markAsRead();
        $this->unreadCount = --$this->unreadCount;
    }


    public function acceptinvitation($boardid, $notificationid){

        $this->markAsRead($notificationid);

        $this->dispatch('invitation-response', [
            'board' => $boardid,
            'response' => 'accepted'
        ]);

        $this->unreadCount = --$this->unreadCount;
    }

    public function declinedinvitation($boardid, $notificationid){

        $this->markAsRead($notificationid);

        $this->dispatch('invitation-response', [
            'board' => $boardid,
            'response' => 'declined'
        ]);

        $this->unreadCount = --$this->unreadCount;
    }


    public function responeTojoin($boardid, $response, $notificationid){

        $user = Auth::user();
        $board = Board::where('id', $boardid)->first();

        if(!$board) return;

        $member = $board->users()->where('user_id', $user->id)->wherePivot('status','pending')->first();

        if(!$member) return;

        $this->markAsRead($notificationid);
        $this->unreadCount = --$this->unreadCount;

        $board->users()->updateExistingPivot($user->id,[
            'status' => $response
        ]);

        $this->dispatch('board-updated');
    }
};
?>

<div
    class="relative"
    x-data="{show : false}">

    <x-heroicon-s-bell
            @click="show = !show"
            class="p-1 w-7 h-7 text-white" />

    @if($unreadCount > 0)
        <span
            @click="show = !show"
            class="absolute top-0 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cursor-default select-none">
            {{ $unreadCount }}
        </span>
    @endif

    <div
        @click.outside="show = false"
        x-show="show"
        class="w-66 bg-stone-100 pt-3 px-2 absolute top-7 right-0 shadow rounded z-100">
            <h1 class="text-md mb-2 font-bold text-gray-600 select-none">Notifications</h1>

            <div class="flex flex-col gap-2 w-full">
                @if (auth()->user()->notifications->count() > 0)
                    @foreach(auth()->user()->notifications->take(7) as $notification)
                        <div class="w-full">
                            <div class="ps-1 block text-base/1 {{ $notification->read_at ? 'opacity-40' : '' }}">
                                <p class="text-xs text-gray-600">{{ $notification->data['message'] }}</p>
                                <div class="flex gap-2">
                                    <span class="block text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if (!$notification->read_at)
                                        <span
                                            wire:click="markAsRead('{{ $notification->id }}')"
                                            class="me-0 ms-auto text-black italic font-semibold text-xs cursor-pointer select-none">mark as read</span>
                                    @endif

                                </div>
                            </div>

                            {{-- user can see invited member buttons but if not readed yet --}}
                            @if ($notification->data['toast_type'] === 'inviteMember' && $notification->read_at === null)
                                <div class="w-full ps-1 flex gap-2 pt-1">
                                    <span
                                        wire:click="responeTojoin('{{ $notification->data['board_id'] }}', 'accepted', '{{ $notification->id }}')"
                                        class="cursor-pointer py-0.5 text-green-600 text-sm font-bold hover:text-green-900 select-none">Accept</span>
                                    <span
                                        wire:click="responeTojoin('{{ $notification->data['board_id'] }}', 'declined', '{{ $notification->id }}')"
                                        class="cursor-pointer py-0.5 px-2 text-red-600 text-sm font-bold hover:text-red-900 select-none">Reject</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-400 italic text-center text-sm">No any notifications</p>
                @endif
            </div>

            <p class="block text-center py-0.5 border-t border-gray-300 mt-3 select-none cursor-pointer" @click="$wire.markAllAsRead()">Mark all as read</p>
    </div>
</div>
