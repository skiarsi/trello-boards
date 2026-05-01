<?php

use Livewire\Component;

new class extends Component
{
    public $list;
};
?>

<div class="w-72 py-1 px-2 flex justify-between" style="background:{{ $list->color }}">

    {{-- list title component --}}
    <livewire:lists.head.title :title="$list->title" />


    <div class="flex gap-3">

        {{-- collapse component --}}
        <livewire:lists.head.collapse :collapse="$list->collapsed" />


        {{-- options components --}}
        <livewire:lists.head.options />

    </div>
</div>
