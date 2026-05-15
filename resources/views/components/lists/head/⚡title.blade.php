<?php

use Livewire\Component;

new class extends Component
{
    public $title;
    public $class;


};
?>

<div>
    <span
        class="{{ $this->class }} text-[1rem] text-black">{{ $title }}</span>
</div>
