<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChecklistItem;

use Illuminate\Support\Facades\Notification;
use App\Notifications\checklist\deleteNotification;
use App\Notifications\checklist\UpdateTitleChecklistNotification;
use App\Notifications\checklist\doneNotification;
use Illuminate\Support\Facades\Auth;


new class extends Component
{
    public $card;
    public $list;
    public $userRole;
    public $checklist;
    public $items;

    public $checklisttitle= '';
    public $checklisttitleTemp= '';

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

        Notification::send(
            $this->list->activeUsers()->get(),
            new doneNotification(
                userId: Auth::id(),
            )
        );
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

        $this->checklisttitle = $this->checklist->title;
        $this->checklisttitleTemp = $this->checklist->title;
    }


    #[On('checklist-newitems')]
    #[On('checklist-titleupdate')]
    public function refreshItems()
    {
        $this->checklist->refresh();

        $this->checklisttitle = $this->checklist->title;
        $this->checklisttitleTemp = $this->checklist->title;

        $this->items = $this->checklist->items()->get();
    }

    public function updatetitle(){
        if($this->checklisttitleTemp === $this->checklisttitle)
            return;

        $this->checklisttitle = $this->checklisttitleTemp;

        $this->checklist->update([
            'title' => $this->checklisttitleTemp
        ]);

        $this->dispatch('checklist-titleupdate');

        Notification::send(
            $this->list->activeUsers()->get(),
            new UpdateTitleChecklistNotification(
                userId: Auth::id(),
            )
        );

        $this->checklisttitleTemp = $this->checklisttitle;
    }
};
?>

<div
    class="mb-3 flex flex-col gap-2 bg-white shadow rounded-lg p-3 w-[98%] me-auto"
    x-data="{
        titleopen: false,
        updatename(){
            this.titleopen= false;
            $wire.updatetitle();
        }
    }">

    <div class="flex gap-3 items-center">
        <x-icon name="check" class="h-6 w-6 border-2 border-gray-700 rounded-md" />
        <h1
            class="select-none"
            @dblclick="titleopen = true; $nextTick(()=>{ $refs.inp_checklisttitle.select() })"
            x-show="!titleopen">{{ $checklisttitle }}</h1>
        <input
            x-show="titleopen"
            @click.outside="updatename()"
            @keyup.enter="updatename()"
            type="text"
            class="input input-md py-0.y rounded-0 text-lg outline-0 w-full"
            wire:model.live = "checklisttitleTemp"
            x-ref="inp_checklisttitle" />
    </div>

    <ul class="ps-10 flex flex-col gap-1 items-start list-disc">
        @foreach ($this->items as $item)
            <li
                class="p-0 text-[1rem] select-none text-gray-700 flex"
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
                        class="mx-1 cursor-pointer text-start hover:text-black {{ $item->is_completed ? 'line-through' : '' }}">{{ $item->title }}</span>

                    @if($item->is_completed && $item->completedBy)
                        <span class="italic">({{ $item->completedBy->name }})</span>
                    @endif
                </div>

                @if ($item->due_date !== null)
                    <div class="flex gap-1 align-middle items-center justify-start" wire:click="">
                        <span class="text-xs text-red-600 italic">Due Date</span>
                        <span class="text-xs select-none cursor-default text-gray-500">{{ $item->due_date->format('Y-m-d') }}</span>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    <livewire:cards.checklist.addnewchecklist :list="$this->list" :checklist="$this->checklist" />
</div>
