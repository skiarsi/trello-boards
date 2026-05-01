<?php

use Livewire\Component;

new class extends Component
{
    public $collapse;
};
?>

<div class="pt-1">
    @if ($collapse)
        <x-bx-expand-horizontal class="w-5 cursor-pointer text-gray-500 hover:text-gray-900" />
    @else
        <x-bx-collapse-horizontal class="w-5 cursor-pointer text-gray-500 hover:text-gray-900" />
    @endif
</div>
