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
            <x-button label="Add label" icon="o-tag" />
            <x-button label="Add Date" icon="o-calendar-days" />
            <x-button label="Add Checklist" icon="o-list-bullet" />
        </div>

        <livewire:cards.labels.manage :list="$list" :card="$this->card" :userRole="$this->userRole" />
</div>
