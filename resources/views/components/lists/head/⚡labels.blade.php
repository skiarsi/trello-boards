<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $list;
    public $userRole;

    #[On('listlable-updated')]
    public function refreshLabels()
    {
        $this->list = $this->list->fresh(['labels']);
    }
};
?>

<div>
    @if ($this->list->labels)
        <div class="w-full grid grid-cols-6 gap-1 pb-1">
            @foreach ($this->list->labels as $label)
                <livewire:lists.head.onelabel
                                :list="$this->list"
                                :userRole="$this->userRole"
                                wire:key="label-{{ $label->id }}"
                                :label="$label" />
            @endforeach
        </div>
    @endif
</div>
