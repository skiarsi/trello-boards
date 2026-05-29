<?php

use Livewire\Component;
use App\Models\Card;
use App\Models\Label;
use App\Models\Boardlist;
use Illuminate\Support\Facades\Notification;
use App\Notifications\cards\labels\NotificationDeletelabel;
use Livewire\Attributes\On;

new class extends Component
{
    public Card $card;
    public Boardlist $list;
    public $userRole;


    #[On('card-label-updated-{card.id}')]
    public function refreshCardLabels()
    {
        $this->card = $this->card->fresh('labels');
    }

    public function deletelabel($labelId){

        if($this->userRole === 'viewer') return;


        $label = Label::findOrFail($labelId);

        if($label){
            $label->delete();
            $this->dispatch('card-label-updated-'.$this->card->id);

            $requestData = [
                'user_id'   => Auth::id(),
                'user_name' => Auth::user()->name
            ];

            Notification::send(
                $this->list->activeUsers()->get(),
                new NotificationDeletelabel(
                    requestData   : $requestData,
                    card          : $this->card
                )
            );
        }
    }
};
?>

<div class="w-80 grid grid-cols-6 gap-1 my-4">
    @if ($this->card->labels)
        @foreach ($this->card->labels as $label)
            <span
                @if($userRole !== 'viewer')
                    @dblclick="if(confirm('Are you sure you want to delete this label?')) { $wire.deletelabel({{ $label->id }}) }"
                    class="tooltip h-3 select-none cursor-pointer"
                @else
                    class="tooltip h-3 select-none"
                @endif
                data-tip="{{ $label->title }}"
                style="background:{{ $label->color }}">&nbsp;</span>
        @endforeach
    @endif
</div>
