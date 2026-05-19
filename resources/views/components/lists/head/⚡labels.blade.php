<?php

use Livewire\Component;

new class extends Component
{
    public $label;
};
?>

<x-popover position="top-start">
    <x-slot:trigger class="w-full">
        <div class="w-full h-2 rounded-full shadow" style="background-color:{{ $this->label->color }}">
            &nbsp;
        </div>
    </x-slot:trigger>
    <x-slot:content class="border w-40 text-sm py-1 px-3 bg-stone-950 text-white">
        {{ $this->label->title }}
    </x-slot:content>
</x-popover>
