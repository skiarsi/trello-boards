<?php

use Livewire\Component;

new class extends Component
{
    public $checklist;
    public $card;
    public $list;
    public $userRole;
};
?>

<div class="w-full mb-3 flex flex-col gap-2">
    <div class="flex gap-3 items-center">
        <x-icon name="check" class="h-6 w-6 border-2 border-gray-700 rounded-md" />
        <h1>{{ $this->checklist->title }}</h1>
    </div>

    <ul class="ps-10 flex flex-col list-disc">
        @foreach ($this->checklist->items as $items)
            <li class="p-0 text-[1rem]">{{ $items->title }}</li>
        @endforeach
    </ul>
    <livewire:cards.checklist.addnewchecklist />
</div>
