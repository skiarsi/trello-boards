<?php

use Livewire\Component;

use Illuminate\Support\Facades\Notification;
use App\Notifications\checklist\NewitemNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $list;
    public $itemtitle='';
    public $checklist;


    public function creatItem(){
        $validate = $this->validate([
            'itemtitle' => 'required|min:4'
        ]);

        $newitem = $this->checklist->items()->create([
            'title' => $validate['itemtitle'],
        ]);

        $this->itemtitle = '';

        $this->dispatch('checklist-newitems');

        Notification::send(
            $this->list->activeUsers()->get(),
            new NewitemNotification(
                username: Auth::user()->name,
                userId: Auth::id(),
                checklistitem: $newitem,
                checklisttitle: $this->checklist->title
            )
        );

    }


    public function resetFormValidation() {
        $this->resetValidation();
    }
};
?>

<div
    x-data="{
        open: false,
        clearandclose() {
            this.open = false;
            {{-- $nextTick(()=> { $refs.input.value = '' }); --}}
            $wire.itemtitle = '';
            $wire.resetFormValidation();
        },
        openform() {
            this.open = true;
            $nextTick(()=> { $refs.input.focus() })
        }
    }"
    class="w-full flex flex-col gap-1">
    <button
        x-show="!open"
        @click="openform()"
        class="py-0.5 text-sm font-bold w-33 cursor-pointer shadow bg-white hover:bg-gray-100 text-black">Add new item</button>
    <div
        x-show="open"
        class="flex flex-col gap-1"
        @click.outside="clearandclose()">
        <input
            x-ref="input"
            type="text"
            wire:keydown.enter="creatItem"
            placeholder="Item title"
            class="input input-sm outline-0 "
            wire:model="itemtitle" />
        @error('itemtitle')
            <span class="text-red-600 italic text-sm">{{ $message }}</span>
        @enderror

        <div class="flex gap-1 items-start">
            <button
                class="py-0 px-3 bg-sky-600 text-white text-sm cursor-pointer"
                wire:click="creatItem">Create</button>
            <button
                @click="clearandclose()"
                class="py-0 px-3 text-black text-sm cursor-pointer">Cancel</button>
        </div>
    </div>
</div>
