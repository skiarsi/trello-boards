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

<div class="W-full mb-5 mt-8 {{ $this->card->checklists ? '' : 'hidden' }}">
    @foreach ($this->card->checklists as $checklist)
        <livewire:cards.checklist.onechecklist
                        :list="$this->list"
                        :card="$this->card"
                        :checklist="$checklist"
                        wire:key="checklist-{{ $checklist->id }}" />
    @endforeach
</div>
