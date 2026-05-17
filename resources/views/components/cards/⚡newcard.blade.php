<?php

use Livewire\Component;

new class extends Component
{
    public $list;
};
?>

<div
    x-data="{
        open : false,

        clearclose(){
            $nextTick(()=> $refs.input.value = '');
            this.open = false
        }
    }"
    class="w-full my-2 gap-1 relative">


    <p
        x-show= "!open"
        @click=" open = true; $nextTick(()=> $refs.input.focus())"
        class="block text-center py-1 select-none cursor-pointer shadow bg-stone-100/40 hover:bg-white">New Card</p>


    <div
        x-show="open"
        class="w-full flex flex-col gap-1">
            <input
                placeholder="Card title..."
                type="text"
                x-ref="input"
                class="w-full px-1 py-0.5 text-lg text-black bg-white border rounded border-stone-300 outline-0" />
            <div class="flex gap-1 items-start py-0.5">
                <button class="py-0 px-4 bg-sky-600 text-white text-sm shadow">Create</button>
                <button @click="clearclose()" class="py-0 px-4 bg-stone-100 text-black text-sm shadow">Cancel</button>
            </div>
    </div>
</div>
