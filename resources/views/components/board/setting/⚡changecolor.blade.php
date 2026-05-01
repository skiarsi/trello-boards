<?php

use Livewire\Component;

new class extends Component
{
    public $board;

    public $color;

    public array $colors = [
        '#B5D4F4',
        '#9FE1CB',
        '#CECBF6',
        '#F5C4B3',
        '#F4C0D1',
        '#FAC775',
        '#C0DD97',
        '#D3D1C7',
        '#5DCAA5',
        '#AFA9EC',
    ];

    public function updatecolor($color){
        if (!in_array($color, $this->colors)) {
            return;
        }

        $this->color = $color;

        // Update board in DB
        $this->board->update(['color' => $this->color]);

        // for close menu
        $this->dispatch('close-dropdown');

        // for change board's color
        $this->dispatch('board-updated');
    }
};
?>

<div class="grid grid-cols-5 w-full gap-1">
    @foreach ($colors as $color)
        <div
            @click="$wire.updatecolor('{{ $color }}')"
            class="w-full py-1 cursor-pointer opacity-80 hover:opacity-100"
            style="background-color:{{ $color }}">&nbsp;</div>
    @endforeach
</div>
