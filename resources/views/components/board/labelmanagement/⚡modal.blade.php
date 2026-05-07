<?php

use Livewire\Component;

new class extends Component
{
    public $board;
    public $labels;


    public function mount(){
        $this->labels = $this->board->load(['labels']);
    }
};
?>

<div
    class="relative z-999"
    x-data="{openModal : false}"
    @open-addlabel.window="openModal = true"
    @resetform.window="openModal=false"
    x-show="openModal"
    >
    <div
        class="fixed top-0 left-0 w-screen h-screen overflow-hidden bg-stone-700/30 flex justify-center items-center z-1000"
        >
        <div
            @click.outside="
                        openModal = !openModal;
                        $dispatch('resetform');
                    "
            class="bg-white w-140 pt-4 pb-4 px-7 rounded-lg flex flex-col gap-2 shadow-xl">
                <div class="w-full text-xl text-gray-700 select-none font-light">Labels</div>


                <livewire:board.labelmanagement.labels mode="manage" :labels="$this->board->labels" :board="$board" />


                <livewire:board.labelmanagement.newlabel-form :board="$board" />
        </div>
    </div>
</div>
