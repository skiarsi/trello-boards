<?php

use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\cards\labels\NotificationCreatelabel;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

new class extends Component
{
    public bool $cardLabelModal = false;

    public $card;
    public $list;

    public $colors = ['#FF3B5C', '#7B2FFF', '#FF6B00', '#00C8F0', '#FF1FA8','#39D353'];
    public $selectedColor;
    public $labeltext;

    public function mount(){
        $this->selectedColor = $this->colors[rand(0,5)];
    }

    #[On('show-card-label-modal')]
    public function showModal(){
        $this->cardLabelModal = true;
    }

    public function chColor($color){
        $this->selectedColor = $color;
    }

    public function createLabel(){
        $validate = $this->validate([
            'labeltext' => 'required|string|min:2|max:25',
            'selectedColor' => ['required' ,Rule::in($this->colors)]
        ]);

        $this->card->labels()->create([
            'title' => $validate["labeltext"],
            'color' => $validate["selectedColor"],
        ]);

        $this->dispatch('card-label-updated-'.$this->card->id);
        $requestData = [
                'user_id'   => Auth::id(),
                'user_name' => Auth::user()->name
            ];

            Notification::send(
                $this->list->activeUsers()->get(),
                new NotificationCreatelabel(
                    requestData   : $requestData,
                    card          : $this->card
                )
            );

        $this->labeltext = '';
        $this->cardLabelModal = false;


    }
};
?>

<div>
    <x-button label="Add label" icon="o-tag" wire:click="showModal" />

    <x-modal wire:model="cardLabelModal" title="Hey" class="backdrop-blur">

        <div class="w-full py-3 px-2" style="background: {{ $this->selectedColor }}">
            <input
                wire:model="labeltext"
                type="text"
                class="input w-full inset-0 focus:border-0"
                placeholder="label's title..." />
        </div>

        <div class="grid grid-cols-6 w-full gap-1 mt-4">
            @foreach ($colors as $color)
                <div
                    wire:click="chColor('{{ $color }}')"
                    wire:key="{{ $color }}"
                    class="h-5 cursor-pointer w-full select-none"
                    style="background: {{ $color }}">&nbsp;</div>
            @endforeach
        </div>

        <x-slot:actions>
            <button
                class="btn btn-info"
                wire:click="createLabel">Create</button>
            <x-button label="Cancel" @click="$wire.cardLabelModal = false" />
        </x-slot:actions>
    </x-modal>
</div>
