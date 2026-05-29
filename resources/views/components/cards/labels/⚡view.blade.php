<?php

use Livewire\Component;
use App\Models\Card;
use Livewire\Attributes\On;

new class extends Component
{
    public Card $card;

    #[On('card-label-updated-{card.id}')]
    public function refreshCardLabels()
    {
        $this->card = $this->card->fresh('labels');
    }

};
?>

<div class="w-full">
    @if ($this->card->labels)
        <div class="grid grid-cols-6 gap-1 w-full">
            @foreach ($this->card->labels as $label)
                <span data-tip="{{ $label->title }}" class="h-2 tooltip  select-none" style="background:{{ $label->color }}">&nbsp;</span>
            @endforeach
        </div>
    @endif
</div>
