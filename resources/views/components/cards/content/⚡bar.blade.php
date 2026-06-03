<?php

use Livewire\Component;
use App\Models\Card;
use App\Models\Boardlist;

new class extends Component
{
    public Card $card;
    public Boardlist $list;
    public $userRole;

    public function mount(){

    }
};
?>

<div

    class="flex flex-col gap-1 w-full py-4">
        <div class="flex gap-2 w-full">
            <livewire:cards.content.addcontent />

            <livewire:cards.labels.addlable :list="$this->list" :card="$this->card" />

            <livewire:cards.dates.add-date :list="$this->list" :card="$this->card" />

            <livewire:cards.checklist.addchecklist :list="$this->list" :card="$this->card" />
        </div>
</div>
