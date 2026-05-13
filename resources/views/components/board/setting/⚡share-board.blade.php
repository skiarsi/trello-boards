<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $board;
    public $myModal1 = false;
    public $users=[];


    public function loadBoardUsers(){
        $this->users = $this->board->users()->get();
    }

    public function mount(){
        $this->loadBoardUsers();
    }
};
?>

<div
    x-data="{
                open : false,
                altPressed : false,
                closeAndClear() {
                    this.open = false;
                }
    }"

    {{-- Share button shortcut --}}
    @keyup.window.alt="altPressed = false"
    @keydown.window.alt="altPressed = true"
    @keydown.escape.window="closeAndClear()"

    @open-share-modal.window="open = true"
    class="relative">
    <button
        @keydown.window.alt.h.prevent="$el.click()"
        @click="open = !open"
        @click="$wire.myModal1 = true"
        class="bg-white text-black py-0.5 px-3 mt-0.5 cursor-pointer">S<span :class="altPressed ? 'underline' : ''">h</span>are this board</button>
    <div
        x-show="open"
        x-cloak
        class="fixed top-0 left-0 w-screen h-screen overflow-hidden bg-stone-700/30 flex justify-center items-center align-middle z-1000">
        <div
            @click.outside=" open = !open "
            class="bg-white w-140 pt-4 pb-6 px-7 rounded-lg flex flex-col gap-4">

            <div class="flex justify-between w-full">
                <div class="w-full text-xl text-gray-700 select-none">Share `<strong>{{ $this->board->title }}</strong>`</div>

                <div
                    class="flex gap-2 cursor-pointer select-none items-start align-middle text-gray-700 hover:text-gray-900"
                    wire:click="$dispatch('userlists-updated')">
                        <x-heroicon-o-arrow-path-rounded-square class="w-5 h-5 mt-0.5" />
                        <span class=" pt-1 pe-2 text-xs">refresh</span>
                </div>

            </div>


            <livewire:board.setting.share.shareform :board="$this->board" />


            <livewire:board.setting.share.userslist :board="$this->board" :users="$users" />
        </div>
    </div>
</div>
