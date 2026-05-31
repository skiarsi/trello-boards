<?php

use Livewire\Component;
use Illuminate\Support\Carbon;

new class extends Component
{
    public $card;

    #[On('card-date-updated-{card.id}')]
    public function cardRefresh(){
    }
};
?>

<div class="{{ !$this->card->due_date ? 'hidden' : 'flex w-max gap-1 items-center text-sm bg-stone-100 border border-stone-300 py-0.5 px-1 select-none rounded-md' }}">

    @if($this->card->due_date)
        <x-icon name="clock" />
        <span>Due Date</span>
        <span class="font-bold">{{ Carbon::parse($this->card->due_date)->format('m/d/Y')}}</span>
    @endif
</div>
