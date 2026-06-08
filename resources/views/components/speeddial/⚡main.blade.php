<?php

use Livewire\Component;
use App\Models\Speeddial;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function speeddial()
    {
        return Speeddial::where('user_id', Auth::id())
                          ->with('board')->get();
    }
};
?>

<div class="flex flex-col w-full justify-center items-center">
    <p class="text-3xl font-bold pt-5">Speed Dial</p>
    <div class="w-full lg:w-9/12 grid grid-cols-4 p-7">
        @foreach ($this->speeddial as $speeddial)
            <a wire:navigate href="{{ route('board', $speeddial->board->slug) }}">
            <div style="background:{{ $speeddial->board->color }}" class="w-full h-40 rounded-xl p-2 shadow relative">

                <p class="absolute w-full bottom-0 left-0 px-3 py-3">{{ $speeddial->board->title }}</p>
            </div>
        @endforeach
    </div>
    </a>
</div>
