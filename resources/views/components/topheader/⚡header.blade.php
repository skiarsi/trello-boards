<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="w-full bg-stone-700 py-2 flex flex-row-reverse justify-between px-4">
    @auth
        <div class="flex gap-2">
            <livewire:blade.header.notifications />
            <x-blade.header.userbutton />
        </div>

        <livewire:topheader.toast />
    @endauth
    @guest
        <x-blade.header.loginbutton />
    @endguest
</div>
