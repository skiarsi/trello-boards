<?php

use Livewire\Component;
use App\Models\Label;
use Illuminate\Validation\Rule;

new class extends Component
{
    public $labeltext;
    public $labelcolor;
    public $board;

    public $colors = ["#FF6B6B","#FFD93D", "#6BCB77", "#4D96FF", "#FF922B", "#6C5CE7"];


    public function createlabel(){

        $validate = $this->validate([
            'labeltext' => 'required|string|min:2|max:25',
            'labelcolor' => [
                                'required' ,
                                Rule::in($this->colors)
                            ]
        ]);

        $this->board->labels()->create([
            'title' => $this->labeltext,
            'color' => $this->labelcolor,
        ]);

        $this->dispatch('label-created');
        $this->dispatch('board-updated');

        $this->reset(['labeltext', 'labelcolor']);
    }
};
?>

<div
    x-data="{
        openForm : false,
        jslabelColor : '',
        chosenColor(data) {
            this.jslabelColor = data.color;
            $wire.set('labelcolor', data.color);
            this.openForm = true,
            setTimeout(() => {
                this.$refs.inputLabel.focus();
            }, 50);
        },
        resetform() {
            this.openForm = false;
            this.jslabelColor = '';
            $wire.set('labeltext','');
            $wire.set('labelcolor','');
        },
    }"
    @open-label-form.window="openForm = true"
    @resetform.window="resetform()"
    @call-chosen-color.window="chosenColor($event.detail)"
    class="w-full pb-2">
    <h1 class="w-full text-xl text-gray-700 select-none font-light mt-4">Add new label</h1>

    <div
        x-show="openForm"
        :style="`background-color: ${jslabelColor}`"
        class="w-full flex gap-1 p-3">

        <input
            type="text"
            wire:model="labeltext"
            x-ref="inputLabel"
            placeholder=""
            class="bg-white py-0.5 px-1 text-lg text-black border border-white flex-1" />

        <button
            class="bg-sky-700 text-white py-1 px-5 cursor-pointer"
            @click="
                $wire.createlabel().then(()=>{
                    openForm = false;
                });
            "
            >Creat</button>
        <button
            @click="openForm = !openForm;"
            class="bg-gray-100 text-black py-1 px-5 cursor-pointer">Cancle</button>
    </div>

    <livewire:board.labelmanagement.new-label />
</div>
