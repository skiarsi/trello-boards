<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $board;
    public $userRole;




    public function createLabel($title, $color)
    {
        $allowedColors = ['#FF6B6B', '#FFD93D', '#6BCB77', '#4D96FF', '#FF922B', '#6C5CE7'];

        $validatedData = \Illuminate\Support\Facades\Validator::make(
            ['title' => $title, 'color' => $color],
            [
                'title' => 'required|string|max:50',
                'color' => ['required', \Illuminate\Validation\Rule::in($allowedColors)],
            ]
        )->validate();

        // add to database
        $newLabel = $this->board->labels()->create([
            'title' => $validatedData['title'],
            'color' => $validatedData['color']
        ]);

        // added to memory
        $this->board->labels->push($newLabel);

        $this->dispatch('board-updated', boardId: $this->board->id);
        $this->dispatch('board-new-label');
    }
};
?>
<div class="relative">

    <div
        class="relative"
        x-data="{
                open: true,
                colorform: false,
                chosenColor: '',
                labelTitle: '',
                errorMessage: '',
                colors: ['#FF6B6B', '#FFD93D', '#6BCB77', '#4D96FF', '#FF922B', '#6C5CE7'],

                choseColor(color) {
                    this.chosenColor = color;
                    this.colorform = true;
                    this.errorMessage = '';
                },

                resetForm() {
                    {{-- this.open = false; --}}
                    this.colorform = false;
                    this.labelTitle = '';
                    this.chosenColor = '';
                    this.errorMessage = '';
                },

                closeModal() {
                    this.open = false;
                    this.colorform = false;
                    this.labelTitle = '';
                    this.chosenColor = '';
                    this.errorMessage = '';
                },

                submitForm() {
                    if(this.labelTitle.trim() === '') {
                        this.errorMessage = 'Title is required!';
                        return;
                    }

                    $wire.createLabel(this.labelTitle, this.chosenColor)
                        .then(() => {
                            this.resetForm();
                        });
                }
            }"
        @open-addlabel.window="open = true"
        x-show="open"
        style="display: none;"
        >
        <div
            class="fixed top-0 left-0 w-screen h-screen overflow-hidden bg-stone-700/30 flex justify-center items-center z-1000">

            <div
                @click.outside="closeModal()"
                class="bg-white w-120 pt-4 pb-4 px-7 rounded-lg flex gap-4 shadow-xl">


                    <div class="flex flex-col gap-4 flex-1">
                        <div class="w-full text-xl text-gray-700 text-center select-none font-bold">Add new label</div>

                        <div class="w-full flex flex-col gap-2">

                            <!-- Color Details & Input Form (No Animation) -->
                            <div
                                x-show="colorform"
                                class="w-full flex flex-col p-3 bg-stone-100 rounded-lg gap-3 border border-stone-200">

                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 rounded-full border border-black/10"
                                            :style="`background-color: ${chosenColor}`">
                                        </span>
                                        <span class="text-xs text-gray-500 uppercase" x-text="chosenColor"></span>
                                    </div>

                                    <input
                                        type="text"
                                        x-model="labelTitle"
                                        @keydown.enter="submitForm()"
                                        placeholder="Enter label title..."
                                        class="bg-white text-black w-full p-2 text-sm border rounded outline-none focus:border-sky-500 border-stone-300"
                                        :class="errorMessage ? 'border-red-500' : 'border-stone-300'"
                                    >

                                    <template x-if="errorMessage">
                                        <span class="text-[10px] text-red-600 font-medium" x-text="errorMessage"></span>
                                    </template>

                                    <button
                                        @click="submitForm()"
                                        class="w-full bg-sky-600 text-white py-1.5 rounded text-sm hover:bg-sky-700">
                                        Save Label
                                    </button>
                            </div>

                            <!-- Color Selection Loop -->
                            <div class="grid grid-cols-1 gap-2">
                                <template x-for="color in colors" :key="color">
                                    <span
                                        @click="choseColor(color)"
                                        class="rounded-lg w-full py-1 text-center cursor-pointer text-white font-bold text-xl"
                                        :style="`background-color: ${color}`"
                                        x-text="chosenColor === color ? '✓' : '+'">
                                    </span>
                                </template>
                            </div>
                        </div>

                        <button
                            @click="closeModal()"
                            class="text-xs w-[90px] ms-0 me-auto bg-stone-200 text-gray-600 py-2 rounded-lg border border-gray-300 hover:bg-stone-100">
                            Close
                        </button>
                    </div>
                    @if ($board->labels && count($board->labels) > 0)
                        {{-- label list / edit --}}
                        <livewire:board.label.labellist
                                :board="$board"
                                :userRole="$userRole"
                                :labels="$board->labels"
                                headtitle="Added labels"
                                mode="manage"  />
                    @endif

            </div>
        </div>
    </div>
</div>
