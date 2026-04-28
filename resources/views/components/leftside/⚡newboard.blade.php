<?php

use Livewire\Component;
use Illuminate\Support\Str;

new class extends Component
{
    public $boardtitle = "";


    public function createnewboard(){

        $validated = $this->validate([
            'boardtitle' => 'string|required|min:3|max:50'
        ]);

        $slug = Str::slug(($this->boardtitle).'-'.now()->timestamp);

        Auth::user()->boards()->create([
            'slug'  => $slug,
            'title' => $this->boardtitle,
            'owner_id' => Auth::id(),
        ],[
            'role'  => 'owner'
        ]);


        $this->reset('boardtitle');



        // dispatching
        $this->dispatch('board-created');


    }
};
?>

<div
    class="w-full flex flex-col"
    x-data="{
                open : false,
                closeAndClear() {
                    this.open = false;
                    $refs.boardInput.value = '';
                }
            }"
    @click.away="closeAndClear()"
    @keydown.escape.window="closeAndClear()"

    >
    <div
        class="cursor-pointer py-2 bg-stone-300 justify-center block"
        x-show="!open"
        @click="open = true; $nextTick(() => { $refs.boardInput.focus() })" >
        <x-heroicon-o-plus class="w-9 h-9 text-gray-600 mx-auto" />
    </div>
    <div
        x-show="open"
        class="w-full flex flex-col gap-1">
        <input
            name="newboardname"
            wire:model="boardtitle"
            type="text"
            x-ref="boardInput"
            @keydown.enter="$wire.createnewboard().then(() => closeAndClear())"
            class="bg-white py-2 px-3 text-lg border border-gray-400" />
        <div class="flex gap-2">
            <button
                wire:loading.attr="disabled"
                wire:target="createnewboard"
                @click="$wire.createnewboard().then(() => closeAndClear())"
                class="bg-sky-900 text-white disabled:bg-gray-300 text-sm py-0.5 px-3">Create</button>
            <button
                class="bg-gray-300 text-black text-sm py-0.5 px-3"
                @click="closeAndClear()"
                >Cancel</button>
        </div>
    </div>
</div>
