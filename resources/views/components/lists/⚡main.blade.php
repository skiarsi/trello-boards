<?php

use Livewire\Component;

new class extends Component
{
    public $list;
};
?>

<div class="w-68 py-1 px-2 flex flex-col" style="background:{{ $list->color }}">

    <div class="w-full flex justify-between">
        {{-- list title component --}}
        <livewire:lists.head.title :title="$list->title" />


        <div class="flex gap-3">

            {{-- collapse component --}}
            <livewire:lists.head.collapse :collapse="$list->collapsed" />


            {{-- options components --}}
            <livewire:lists.head.options />

       </div>
    </div>
    <div class="w-full">

        <livewire:cards.allcards :list="$list" />

    </div>
</div>
