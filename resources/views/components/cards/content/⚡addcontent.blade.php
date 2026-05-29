<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div
    x-date="{
                show : false,
            }"
    class="relative">
        {{-- <x-button label="Add" icon="o-plus" /> --}}
        <x-dropdown label="Add">
            <x-menu-item icon="o-tag" title="Labels" class="w-60" />
            <x-menu-item icon="o-calendar-days" title="Date" class="w-60" />
            <x-menu-item icon="o-list-bullet" title="Checklist" class="w-60" />
        </x-dropdown>
</div>
