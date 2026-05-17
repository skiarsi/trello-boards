<?php

use Livewire\Component;

new class extends Component
{
    public $label;
};
?>

<div class="w-full h-2 rounded-full" style="background-color:{{ $this->label->color }}">
    &nbsp;
</div>
