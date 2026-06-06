<?php

use Livewire\Component;

new class extends Component
{
    public $list;
    public $card;
};
?>

<div>
    <x-button
        label="Add Checklist"
        icon="o-list-bullet"
        @click="$dispatch('create-new-checklist')" />
</div>
