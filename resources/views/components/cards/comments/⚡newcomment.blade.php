<?php

use Livewire\Component;

new class extends Component
{
    public $commenttext='';
};
?>

<div class="px-3 w-full">
    <h1 class="text-md font-bold text-gray-800 select-none">Comments and activity</h1>

    <input
        type="text" class="input outline-0 w-full focus:border-gray-200 mt-4"
        placeholder="Add comment..."
        wire:model = "commenttext" />


    <hr class="mt-3 mb-2 mx-auto w-10/12 border border-gray-200" />
</div>
