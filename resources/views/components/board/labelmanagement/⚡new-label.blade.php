<?php

use Livewire\Component;

new class extends Component
{
    public $colors = ["#FF6B6B","#FFD93D", "#6BCB77", "#4D96FF", "#FF922B", "#6C5CE7"];
};
?>

<div
    x-data="{
        selectedcolor : ''
    }"
    class="grid grid-cols-2 gap-2 w-full pt-6">
    @foreach ($colors as $color)
        <div
            wire:key="color-{{ $color }}"
            @click="
                $dispatch('open-label-form');
                $dispatch('call-chosen-color',{ color: '{{ $color }}' });
            "
            class="py-1 w-full mx-auto rounded select-none cursor-pointer opacity-85 hover:opacity-100"
            style="background-color:{{ $color }}">&nbsp;</div>
    @endforeach

    <button
        @click="
            $dispatch('resetform');
        "
        class="text-white text-lg ms-0 me-auto py-1 px-7 mt-5 bg-gray-500">Close</button>
</div>
