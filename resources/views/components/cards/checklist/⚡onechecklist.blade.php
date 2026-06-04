<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChecklistItem;

use Illuminate\Support\Facades\Notification;
use App\Notifications\checklist\deleteNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $card;
    public $list;
    public $userRole;
    public $checklist;
    public $items;

    public function doneitem($itemid){
        $item = ChecklistItem::find($itemid);

        if($item->is_completed == 0){
            $item->is_completed = 1;
            $item->completed_by_id = auth()->id();
        }else{
            $item->is_completed = 0;
            $item->completed_by_id = null;
        }

        $item->save();

        $this->dispatch('checklist-newitems');
    }


    // delete item
    public function deleteitem($itemid){
        $item = ChecklistItem::find($itemid);
        if ($item) {
            $item->delete();
        }


        $this->dispatch('checklist-newitems');

        Notification::send(
            $this->list->activeUsers()->get(),
            new deleteNotification(
                userId: Auth::id(),
            )
        );
    }


    public function mount(){
        $this->items = $this->checklist->items;
    }


    #[On('checklist-newitems')]
    public function refreshItems()
    {
        $this->items = $this->checklist->items()->get();
    }
};
?>

<div class="w-full mb-3 flex flex-col gap-2">
    <div class="flex gap-3 items-center">
        <x-icon name="check" class="h-6 w-6 border-2 border-gray-700 rounded-md" />
        <h1>{{ $this->checklist->title }}</h1>
    </div>

    <ul class="ps-10 flex flex-col gap-1 items-start list-disc">
        @foreach ($this->items as $item)
            <li
                class="p-0 text-[1rem] select-none text-gray-700 flex gap-1"
                >
                @if ($this->userRole !== 'viewer')
                    <x-icon
                            wire:confirm="are you sure you want to delete this this item?"
                            wire:click="deleteitem({{ $item->id }})"
                            name="trash"
                            class="w-5 h-5 mt-1 cursor-pointer text-gray-500 hover:text-gray-900" />
                @endif

                <div class="bg-white px-3 py-0.5 shadow rounded-xs">
                    <span
                        wire:click="doneitem({{ $item->id }})"
                        class="cursor-pointer text-start hover:text-black {{ $item->is_completed ? 'line-through' : '' }}">{{ $item->title }}</span>

                    @if($item->is_completed && $item->completedBy)
                        <span class="italic">({{ $item->completedBy->name }})</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
    <livewire:cards.checklist.addnewchecklist :list="$this->list" :checklist="$this->checklist" />
</div>
