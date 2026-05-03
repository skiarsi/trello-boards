<?php

use Livewire\Component;

new class extends Component
{
    public $board;
    public $users=[];

    public function mount(){
        $this->users = $this->board->users()->get();
    }
};
?>

<div
    x-data="{open : false}"
    @open-share-modal.window="open = true"
    class="relative">
    <button
        @click="open = !open"
        class="bg-white text-black py-0.5 px-3 mt-0.5 cursor-pointer">Share this board</button>

    <div
        x-show="open"
        x-cloak
        class="fixed top-0 left-0 w-screen h-screen overflow-hidden bg-stone-700/30 flex justify-center items-center align-middle z-1000">
        <div
            @click.outside=" open = !open "
            class="bg-white w-140 overflow-hidden pt-4 pb-6 px-7 rounded-lg flex flex-col gap-4">
                <div class="w-full text-xl text-gray-700 select-none">Share `<strong>{{ $this->board->title }}</strong>`</div>




            <livewire:board.setting.share.userslist :users="$users" />
        </div>
    </div>
</div>
