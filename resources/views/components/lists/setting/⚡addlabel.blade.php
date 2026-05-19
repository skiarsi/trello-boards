<?php

use Livewire\Component;

new class extends Component
{
    public $list;
    public $labeltitle='';
    public $selectedcolor;

    public $colors = ["#FF6B6B","#FFD93D", "#6BCB77", "#4D96FF", "#FF922B", "#6C5CE7"];



    public function updatecolor($color){
        $this->selectedcolor = $color;
    }

    public function mount(){
       $this->selectedcolor = $this->colors[rand(0, 5)];
    }
};
?>

<div
    x-data="{open : false, listId: {{ $this->list->id }}}"
    @open-addlistlabel.window= "open = ($event.detail.listId === listId)"
    class="w-full"
    >
    <div
        x-show = "open"
        @click.outside="open = false"
        class="flex flex-col gap-1 py-2 bg-white/40 px-3 rounded-lg my-1">
            <div class="w-full grid grid-cols-6 gap-1">
                @foreach ($colors as $color)
                    <div
                        wire:click="updatecolor('{{ $color }}')"
                        class="w-full h-4 py-1 cursor-pointer opacity-80 shadow hover:opacity-100"
                        style="background-color:{{ $color }}">&nbsp;</div>
                @endforeach
            </div>
            <div class="flex gap-1">

                <div
                    class="w-5 h-full rounded-lg"
                    style="background-color: {{ $this->selectedcolor }}">&nbsp;</div>

                <input
                    wire:model="labeltitle"
                    type="text"
                    class="flex-1 bg-white border border-gray-400 text-black py-0.5 px-2 text-sm w-full rounded-sm"
                    placeholder="Label title..." />
            </div>

            <div class="flex gap-1">
                <button class="bg-sky-700 text-white py-0 px-4 text-sm cursor-pointer">create</button>
                <button @click="open = false" class="text-black px-4 text-sm cursor-pointer">cancel</button>
            </div>
    </div>
</div>
