<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component
{
    #[Reactive]
    public $collapse;
};
?>

<div class="pt-0.5" wire:click="$parent.collapsing">
    @if ($collapse)
        <x-bx-expand-horizontal class="w-5 cursor-pointer text-gray-500 hover:text-gray-900" />
    @else
        <x-bx-collapse-horizontal class="w-5 cursor-pointer text-gray-500 hover:text-gray-900" />
    @endif
</div>
