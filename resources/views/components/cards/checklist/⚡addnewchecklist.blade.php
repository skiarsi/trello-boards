<?php

use Livewire\Component;

new class extends Component
{
    public $itemtitle='';
};
?>

<div
    x-data="{
        open: false,
        clearandclose() {
            this.open = false;
        },
        openform() {
            this.open = true;
        }
    }"
    class="w-full flex flex-col gap-1">
    <button
        x-show="!open"
        @click="openform()"
        class="py-0.5 text-sm font-bold w-33 cursor-pointer shadow bg-white hover:bg-gray-100 text-black">Add new item</button>
    <div
        x-show="open"
        class="flex flex-col gap-1">
        <input
            type="text"
            placeholder="Item title"
            class="input input-sm"
            wire:model="itemtitle" />

        <div class="flex gap-1 items-start">
            <button class="py-0 px-3 bg-sky-600 text-white text-sm cursor-pointer">Create</button>
            <button
                @click="clearandclose()"
                class="py-0 px-3 text-black text-sm cursor-pointer">Cancel</button>
        </div>
    </div>
</div>
