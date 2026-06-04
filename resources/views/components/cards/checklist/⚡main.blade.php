<?php

use Livewire\Component;

new class extends Component
{
    // public $checklists = [];

    public $list;
    public $card;
    public $userRole;

    public function mount(){
    }
};
?>

<div class="W-full mb-5 mt-8 ps-1 max-h-100 overflow-auto {{ $this->card->checklists ? '' : 'hidden' }}">
    @foreach ($this->card->checklists as $checklist)
        <livewire:cards.checklist.onechecklist
                        :list="$this->list"
                        :card="$this->card"
                        :checklist="$checklist"
                        :userRole="$userRole"
                        wire:key="checklist-{{ $checklist->id }}" />
    @endforeach
</div>
