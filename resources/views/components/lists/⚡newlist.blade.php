<?php

use Livewire\Component;
use Illuminate\Support\Str;
use App\Notifications\lists\CreateNewNotification;


new class extends Component
{
    public $board;
    public $listtitle = '';
    public $list = null;

    public function createnewlist(){

        $this->validate([
            'listtitle' => 'required|min:3'
        ]);

        $slug = Str::slug(($this->listtitle).'-'.now()->timestamp);
        $list = $this->board->lists()->create([
            'slug'  => $slug,
            'title' => $this->listtitle,
        ]);

        $this->dispatch('list-created');

        $this->board->activeUsers()
                        ->each(function($members) use ($list){
                            $members->notify(new CreateNewNotification(
                                board: $this->board,
                                list: $list,
                                message: ''
                            ));
                        });


    }
};
?>

<div
    x-data="{
        altPressed: false,
        open: false,
        closeAndClear() {
            this.open = false;
            this.$refs.listInput.value = '';
        }
    }"

    @list-created.window="closeAndClear()"

    {{-- L shortcut --}}
    @keydown.window.alt="altPressed = true"
    @keyup.window.alt="altPressed = false"

    @keydown.window.l="if (altPressed && !['INPUT', 'TEXTAREA'].includes($event.target.tagName)) {
        $event.preventDefault();
        open = true;
        $nextTick(() => $refs.listInput.focus());
    }"

    @keydown.escape.window="closeAndClear()"
    class="w-68 shrink-0 flex flex-col cursor-pointer select-none"
>

    {{-- New label button --}}
    <div
        @click="open = true; $nextTick(() => $refs.listInput.focus())"
        x-show="!open"
        class="w-full flex gap-1 bg-black/30 hover:bg-black/50 justify-center">
        <x-heroicon-o-plus class="w-9 h-9 text-gray-100" />
        <p class="text-center text-xs pt-2.5 text-gray-100">
            New <span :class="altPressed ? 'underline font-bold' : ''">L</span>ist
        </p>
    </div>

    {{-- Form --}}
    <div
        x-show="open"
        @click.outside="closeAndClear()"
        class="w-full flex flex-col py-1 px-2 bg-black/30">
        <span class="text-sm text-white pb-1">Create new list</span>
        <input
            x-ref="listInput"
            wire:model="listtitle"
            type="text"
            class="bg-white py-1 text-lg px-2 border border-gray-400 text-black"
            {{-- @keydown.enter="$wire.createnewlist().then(() => closeAndClear())" --}}
            @keydown.enter="$wire.createnewlist()"
            placeholder="List name..." />

        @error('listtitle')
            <span @click.outside="$el.remove()" class="text-xs bg-red-300 text-red-700 p-0.5 rounded-sm italic my-1">{{ $message }}</span>
        @enderror

        <div class="flex gap-1 w-full pt-1">
            <button
                @click="$wire.createnewlist()"
                class="bg-sky-900 text-white text-sm py-0.5 px-3">Create</button>
            <button
                @click="closeAndClear()"
                class="bg-gray-300 text-black text-sm py-0.5 px-3">Cancel</button>
        </div>
    </div>
</div>
