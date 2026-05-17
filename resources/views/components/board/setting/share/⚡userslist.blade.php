<?php

use Livewire\Component;

new class extends Component
{
    public $board;
};
?>

<div class="w-fullselect-none border-t border-gray-400 flex flex-col pt-1">
    <div class="tabs tabs-border z-10">
        <input type="radio" name="my_tabs_2" class="tab" aria-label="Members" checked="checked" />
        <livewire:board.setting.share.members :board="$this->board" />

        <input type="radio" name="my_tabs_2" class="tab" aria-label="Joining requests" />
        <livewire:board.setting.share.joiningrequest :board="$this->board" />
    </div>
</div>
