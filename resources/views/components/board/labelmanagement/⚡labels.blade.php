<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $labels;
    public $board;
    public $mode = "show";

    #[On('label-created')]
    public function refreshLabels(){
        $this->labels = $this->board->labels()->get();
    }
};
?>

<div
    @class([
        'grid gap-1 w-full',
        'grid-cols-2' => $this->mode === 'manage',
        'grid-cols-6' => $this->mode !== 'manage',
    ])>
    @foreach ($labels as $label)
        <div class="flex gap-2 justify items-start py-1 ps-1 " style="background-color:{{ $label->color }}">
            @if($this->mode === "manage")
                <x-heroicon-o-trash class="w-7 h-7 ms-0 p-1 border rounded-full bg-white cursor-pointer" />
                <span class="text-sm pt-1">{{ $label->title }}</span>
            @endif
        </div>
    @endforeach
</div>
