<?php

use Livewire\Component;

new class extends Component
{
    public $board;

    public function createnewlist(){

    }
};
?>

<div
    x-data="{
                open : false,
                closeAndClear() {
                    this.open = false;
                    $refs.listInput.value = '';
                }
            }"
    @open-newlistform.window="
                            open = true;
                            $nextTick(()=> { $refs.listInput.focus() })
                        "
    @keydown.escape.window="closeAndClear()"
    class="w-68 flex flex-col cursor-pointer select-none">

    <x-heroicon-o-plus
        @click="open = !open; $nextTick(()=> { $refs.listInput.focus() })"
        x-show="!open"
        class="w-full h-9 text-gray-100 mx-auto bg-black/30 hover:bg-black/50" />

    <div
        x-show="open"
        @click.outside="open = !open"
        class="w-full flex flex-col py-1 px-2 bg-black/30">
            <span class="text-sm text-white pb-1">Create new list</span>
            <input
                x-ref="listInput"
                type="text"
                class="bg-white py-1 text-lg px-2 border border-gray-400"
                @keydown.enter="$wire.createnewlist().then(() => closeAndClear())"
                placeholder="Card name" />

            <div class="flex gap-1 w-full pt-1">
                <button
                    @click="$wire.createnewlist().then(() => closeAndClear())"
                    class="bg-sky-900 text-white disabled:bg-gray-300 text-sm py-0.5 px-3">Create</button>
                <button
                    class="bg-gray-300 text-black text-sm py-0.5 px-3"
                    @click="closeAndClear()"
                    >Cancel</button>
            </div>
    </div>
</div>
