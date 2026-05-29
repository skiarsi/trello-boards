<?php

use Livewire\Component;

new class extends Component
{
    public $list;

};
?>

<div
    x-data="{
        show : false
    }"
    @close-menu.window="show = false",
    class="relative w-5 select-none">

    <x-heroicon-c-ellipsis-vertical
        @click.stop="show = !show"
        class="absolute right-0 top-0.5 w-6 p-1 cursor-pointer hover:text-gray-900" />

    <div
        @click.outside="show = false"
        x-show="show"
        class="w-60 bg-white rounded shadow absolute top-1 right-0 p-3 z-10 flex flex-col"
        style="display: none;">

        <div
            @click.stop="
                $dispatch('open-newcard', { listId: {{ $this->list->id }} });
                show = false
            "
            class="flex gap-2 items-start py-0.5 w-full cursor-pointer group">
            <x-heroicon-s-plus class="w-5 h-5 mt-1 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">New Card</span>
        </div>

        <div
            @click.stop="
                $dispatch('open-addlistlabel', {listId: {{ $this->list->id }} });
                show = false
            "
            class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
            <x-heroicon-c-ticket class="w-4 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Add label</span>
        </div>

        <div
            @click.stop="
                $dispatch('open-rename', {listId: {{ $this->list->id }} });
                show = false
            "
            class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
            <x-heroicon-s-pencil-square class="w-4 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Rename labale</span>
        </div>

        <div class="w-full px-1 pb-1 flex flex-col">
            <div class="flex gap-2 items-start py-1 w-full group">
                <x-heroicon-s-paint-brush class="w-4 h-4 mt-1.5 text-gray-500" />
                <span class="block py-1 text-sm text-gray-900 ">change color</span>
            </div>

            <livewire:lists.setting.changecolor :list="$this->list" />
        </div>

        <livewire:lists.setting.archive :list="$list" />
    </div>
</div>
