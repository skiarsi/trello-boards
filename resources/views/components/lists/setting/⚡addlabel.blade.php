<?php

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\lists\NewLabelNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $list;
    public $title='';
    public $selectedcolor;

    public $colors = ["#FF6B6B","#FFD93D", "#6BCB77", "#4D96FF", "#FF922B", "#6C5CE7"];

    public function updatecolor($color){
        $this->selectedcolor = $color;
    }

    public function mount(){
       $this->firstLabelColor();
    }

    public function firstLabelColor(){
        $this->selectedcolor = $this->colors[rand(0, 5)];
    }

    public function createLabel(){
        $validate = $this->validate([
            'title'    => 'required|string|min:2|max:25',
            'selectedcolor' => [
                                'required' ,
                                Rule::in($this->colors)
                            ]
        ]);

        // create new label
        $this->list->labels()->create([
            'title' => $this->title,
            'color' => $this->selectedcolor,
        ]);

        $this->dispatch('listlable-updated');

        Notification::send(
            $this->list->activeUsers()->get(),
            new NewLabelNotification(
                list: $this->list,
                labeltitle: $this->title,
                sender: Auth::user()
            )
        );

        $this->title = '';
        $this->selectedcolor = $this->colors[rand(0, 5)];
    }
};
?>

<div
    x-data="
        {
            open : false,
            listId: {{ $this->list->id }},
            clearclose(){
                this.open = false,
                $refs.inputLabel.value = ''
            }
        }
        "
    @open-addlistlabel.window= "
                                    open = ($event.detail.listId === listId);
                                    $nextTick(() => $refs.inputLabel.focus());
                               "
    class="w-full"
    >
    <div
        x-show = "open"
        @click.outside="clearclose()"
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
                <div class="flex-1">
                    <input
                        wire:model="title"
                        type="text"
                        @keydown.enter="$wire.createLabel"
                        @keydown.escape="clearclose()"
                        x-ref="inputLabel"
                        class=" bg-white border border-gray-400 text-black py-0.5 px-2 text-sm w-full rounded-sm"
                        placeholder="Label title..." />

                    @error('title')
                        <span class="block mt-0.5 text-red-700 bg-white px-1 rounded-sm text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-1">
                <button wire:click="createLabel" class="bg-sky-700 text-white py-0 px-4 text-sm cursor-pointer">create</button>
                <button @click="clearclose()" class="text-black px-4 text-sm cursor-pointer">cancel</button>
            </div>
    </div>
</div>
