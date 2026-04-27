<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="w-full bg-stone-700 rounded-xl py-2 flex flex-row-reverse justify-between px-4">
    @auth
        <x-blade.header.userbutton />
    @endauth
    @guest
        <x-blade.header.loginbutton />
    @endguest
</div>
