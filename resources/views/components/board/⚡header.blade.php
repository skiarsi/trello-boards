<?php

use Livewire\Component;

new class extends Component
{
    public $board;
    public $boardTitle = '';

    // update board title
    public function updateBoardTitle(){
        $this->validate([
            'boardTitle' => 'required|string|min:3|max:50'
        ]);

        $this->board->title = $this->boardTitle;
        $this->board->save();

        $this->boardTitle = $this->board->title;


        // this patch update board name
        $this->dispatch('board-updated');
    }

    public function mount(){
        $this->boardTitle = $this->board->title;
    }
};
?>

<div
    x-data="{
        editing : false,
        initialValue: '',
        startEditing() {
            this.initialValue = $refs.InputBoardTitle.value;
            this.editing = true;
            $nextTick(() => {
                $refs.InputBoardTitle.focus();
                $refs.InputBoardTitle.select();
            });
        },
        handleOutside() {
            if (this.editing) {
                let newValue = $refs.InputBoardTitle.value;
                if (newValue !== this.initialValue) {

                    // first update name on livewire
                    $wire.updateBoardTitle().then(() => {

                        // change title after name is change on server
                        document.title = newValue;
                        this.editing = false;

                    });
                } else {
                    this.editing = false;
                }
            }
        }
    }"
    {{-- x-init="$watch('$wire.boardTitle', value => { document.title = value })" --}}
    class="bg-gray-800/80 w-full py-2 flex justify-between px-4">

    <div>
        <span
            class="text-white text-lg"
            x-show="!editing"
            @click="startEditing()"
            >{{ $boardTitle }}</span>

        <input
            type="text"
            wire:model="boardTitle"
            x-show="editing"
            x-ref="InputBoardTitle"
            @click.outside="handleOutside()"
            @keydown.enter="handleOutside()"
            @keydown.escape="editing = false; boardTitle = initialValue"
            class="py-0.5 px-2 bg-white text-black rounded-none outline-0" />
    </div>

    <livewire:board.settingmenu :board="$board" />
</div>
