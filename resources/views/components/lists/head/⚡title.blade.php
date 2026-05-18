<?php

use Livewire\Component;

new class extends Component
{
    public $list;
    public $labels;
    public $class;

};
?>

<div class="flex flex-col w-full">
    <span
        class="{{ $this->class }} text-[1.1rem] text-black">{{ $this->list->title }}</span>

    @if ($this->labels)
        <div class="w-full grid grid-cols-6 pb-1">
            @foreach ($this->labels as $label)
                <livewire:lists.head.labels wire:key="label-{{ $label->id }}" :label="$label" />
            @endforeach
        </div>
    @endif
</div>
