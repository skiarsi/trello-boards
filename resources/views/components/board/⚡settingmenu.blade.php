<?php

use Livewire\Component;

new class extends Component
{
    public $board;

    // auth user role in this board
    public $userRole;
};
?>

<div
    class="relative"
    x-data="
        {
            open: false,
        }"
    >
    <x-heroicon-c-ellipsis-vertical
        class="w-8 p-1 text-white cursor-pointer hover:text-gray-500"
        @click="open = !open"


        {{-- Window dispatch --}}
        @close-dropdown.window="open = false" />

    <div
        class="absolute flex flex-col w-55 bg-white shadow py-2 px-2 rounded right-0 top-8 select-none"
        x-show="open"
        @click.outside="open = !open">

        @if ($userRole !== 'viewer')
            <span class="block py-1 ps-1 text-sm text-gray-900 hover:text-gray-700 cursor-pointer">Add new list</span>
            <span class="block py-1 ps-1 text-sm text-gray-900 hover:text-gray-700 cursor-pointer">Share board</span>

            <div class="w-full px-1 py-1 flex flex-col">
                <span class="block py-1 text-sm text-gray-900">change color</span>

                {{-- change color --}}
                <livewire:board.setting.changecolor :board="$board" />
            </div>
            <span class="block py-1 ps-1 text-sm text-gray-900 hover:text-gray-700 cursor-pointer">Add label</span>
        @else
            <span class="block py-1 ps-1 text-sm text-gray-900 hover:text-gray-700 cursor-pointer">Add label</span>
        @endif


    </div>
</div>
