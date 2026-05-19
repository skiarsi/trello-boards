<?php

use Livewire\Component;
use App\Models\Boardlist;

new class extends Component
{
    public $list;
    public $labels = [];
    public $class;

    public function mount(){
        $this->labels = Boardlist::where('id', $this->list->id)
                                    ->with(['labels'])->get(); //$this->list->load(['labels'])->get();
    }

};
?>

<div class="flex flex-col w-full">
    <span
        class="{{ $this->class }} text-[1.1rem] text-black">{{ $this->list->title }}</span>

    @if ($this->labels)
        <div class="w-full grid grid-cols-6 gap-1 pb-1">
            @foreach ($this->list->labels as $label)
                <livewire:lists.head.labels wire:key="label-{{ $label->id }}" :label="$label" />
            @endforeach
        </div>
    @endif
</div>
