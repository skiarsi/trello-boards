<?php

use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $board;
    public $userRole;


    // #[Computed]
    // public function userRole()
    // {
    //     return $this->board->currentUserRole();
    // }

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
        class="absolute flex flex-col w-55 bg-white shadow py-2 px-2 rounded right-0 top-1 select-none"
        x-show="open"
        @click.outside="open = !open">

        @if ($this->userRole !== 'viewer')
            <div
                class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group"
                @click="
                    $dispatch('open-newlistform');
                    open = !open
                ">
                <x-heroicon-s-view-columns class="W-43 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
                <span
                    class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Add new list</span>
            </div>

            <div
                @click="
                    $dispatch('open-addlabel');
                    open = !open
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
                <livewire:board.setting.changecolor :board="$board" />
            </div>

            @if ($this->userRole === "owner")

                <livewire:board.setting.archive.addtoarchive :board="$board" />

                <div class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
                    <x-heroicon-c-share class="W-43 h-4 mt-0.5 text-gray-500 group-hover:text-gray-400" />
                    <span
                        @click="
                            $dispatch('open-share-modal'); {{-- Open share modal --}}
                            open = false; {{-- close menu --}}
                        "
                        class="text-sm text-gray-900 group-hover:text-gray-700 "
                        >Share board</span>
                </div>
            @endif
        @else
            <div class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
                <x-heroicon-c-ticket class="W-43 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
                <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Add label</span>
            </div>
        @endif


    </div>
</div>
