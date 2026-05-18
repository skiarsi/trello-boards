<?php

use Livewire\Component;
use Illuminate\Support\Str;
use App\Notifications\cards\NewCardNotification;

new class extends Component
{
    public $list;
    public $board;
    public $cardtitle='';


    public function createCard(){
        $validated = $this->validate([
            'cardtitle' => 'required|min:2',
        ], [
            'cardtitle.required' => 'Please enter a title for your card.',
            'cardtitle.min'      => 'The card title must be at least 2 characters long.',
        ]);

        $card = $this->list->cards()->create([
            'slug' => Str::slug($validated['cardtitle'] . '-' . now()->toDateTimeString()),
            'title' => $validated['cardtitle']
        ]);

        $this->dispatch('card-created');

        $this->list->activeUsers()
                        ->each(function($members) use($card){
                            $members->notify(new NewCardNotification(
                                list: $this->list,
                                card: $card,
                                message: ''
                            ));
                        });

        $this->cardtitle = '';
    }
};
?>

<div
    x-data="{
        open : false,

        clearclose(){
            $nextTick(()=> $refs.input.value = '');
            this.open = false
        }
    }"
    class="w-full my-2 gap-1 relative">


    <p
        x-show= "!open"
        @click=" open = true; $nextTick(()=> $refs.input.focus())"
        class="block text-center py-1 select-none cursor-pointer shadow bg-stone-100/40 hover:bg-white">New Card</p>


    <div
        x-show="open"
        @click.outside=" open = false; clearclose() "
        class="w-full flex flex-col gap-1">
            <input
                wire:model="cardtitle"
                placeholder="Card title..."
                type="text"
                x-ref="input"
                class="w-full px-1 py-0.5 text-lg text-black bg-white border rounded border-stone-300 outline-0" />
                @error('cardtitle') <span class="text-red-700 text-sm italic">{{ $message }}</span> @enderror
            <div class="flex gap-1 items-start py-0.5">
                <button
                    wire:click="createCard"
                    class="py-0 px-4 bg-sky-600 text-white text-sm shadow">Create</button>
                <button @click="clearclose()" class="py-0 px-4 bg-stone-100 text-black text-sm shadow">Cancel</button>
            </div>
    </div>
</div>
