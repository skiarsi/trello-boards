<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\cards\CardColorNofitication;

new class extends Component
{
    public $list;
    public $card;
    public $cardcolor;
    public $pickedcolor;


    public $colorslist = ['#FF6B6B','#FFD93D','#6BCB77','#4D96FF','#FF9F43','#FF80AC','#10AC84','#5F27CD','#FF4757','#2ED573','#1E90FF','#FFA502'];


    public function updateColor($colr){

        $this->card->update([
            'color' => $colr
        ]);

        $this->dispatch('card-updated', listId : $this->list->id);

        Notification::send(
            $this->list->activeUsers()->get(),
            new CardColorNofitication(
                userId: Auth::id(),
                listId: $this->list->id
            )
        );
    }
};
?>

<div x-data="{
                open: false,
            }"
     class="relative">
    <x-button
        label="Add Color Cover"
        icon="o-swatch"
        @click="open = true" />

    <div
        x-show="open"
        @click.outside="open = false"
        class="w-70 flex flex-col bg-stone-50 rounded-md shadow-lg z-40 absolute top-5 left-2 py-3 px-4">

        <h1 class="pt-2 text-lg select-none">Pick a color</h1>
        <div class="grid grid-cols-6 gap-1">
            @foreach ($this->colorslist as $color)
                <div
                    wire:click="updateColor('{{ $color }}')"
                    class="w-full h-9 select-none cursor-pointer"
                    style="background: {{ $color }}">&nbsp;</div>
            @endforeach
        </div>

        @if ($this->card->color !== null)
            <hr class="my-3 border border-stone-300" />
            <p class="text-lg select-none cursor-pointer">Remove color</p>
        @endif
    </div>
</div>
