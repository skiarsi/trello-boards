<?php

use Livewire\Component;

new class extends Component
{
    public $list;
};
?>

<div
    x-data="{
        open : false
    }"
    class="relative w-5">

    <x-heroicon-c-ellipsis-vertical
        @click="open = true"
        class="absolute right-0 top-0.5 w-6 p-1 cursor-pointer hover:text-gray-900" />

    <div
        @click.outside="open = false"
        X-show="open"
        class="w-60 bg-white rounded shadow absolute top-1 right-0 p-3 z-10 flex flex-col">

        <div
            @click="
                open = !open
            "
            class="flex gap-2 items-start py-0.5 w-full cursor-pointer group">
            <x-heroicon-s-plus class="W-5 h-5 mt-1 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">New Card</span>
        </div>

        <div
            @click="
                open = !open
                $dispatch('open-addlistlabel', {listId: {{ $this->list->id }} });
            "
            class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
            <x-heroicon-c-ticket class="W-4 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Add label</span>
        </div>


        <div class="w-full px-1 pb-1 flex flex-col">
            <div class="flex gap-2 items-start py-1 w-full group">
                <x-heroicon-s-paint-brush class="W-43 h-4 mt-1.5 text-gray-500" />
                <span class="block py-1 text-sm text-gray-900 ">change color</span>
            </div>

            {{-- change color --}}
            <livewire:lists.setting.changecolor :list="$this->list" />
        </div>


    </div>
</div>
