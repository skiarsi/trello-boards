<?php

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\cards\dates\NotificationCardDateAdd;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public bool $cardDateModal = false;

    public $list;
    public $card;

    public $endDate;


    public function mount(){
        $this->endDate = $this->card->due_date
                        ? Carbon::parse($this->card->due_date)->format('Y-m-d')
                        : null;
    }


    #[On('show-card-date-modal')]
    public function showModal(){
        $this->cardDateModal = true;
    }

    public function addDate(){

        // if it's null save as null if not save as Carbon date
        $enddate = $this->endDate === null ? null : Carbon::parse($this->endDate);

        $today = Carbon::now();

        $this->card->update([
            'due_date' => $enddate
        ]);

        // $this->cardDateModal = false;
        $this->dispatch('card-date-updated-'.$this->card->id);

        $requestData = [
            'user_name' => Auth::user()->name
        ];

        Notification::send(
            $this->list->activeUsers()->get(),
            new NotificationCardDateAdd(
                card          : $this->card,
                requestData   : $requestData,
            )
        );

    }
};
?>

<div>
    <x-button label="Add Date" icon="o-calendar-days" wire:click="showModal" />

    <x-modal wire:model="cardDateModal" title="Add Date" class="backdrop-blur">
        <div class="w-10/12 mx-auto flex flex-col gap-1 justify-start">
            <x-datetime
                label="End Date"
                wire:model.live="endDate"
                wire:keydown.enter="addDate"
                icon="o-calendar"
                {{-- type="datetime-local" --}}
                class="outline-0 focus:border-0" />

            @if ($this->endDate)
                <button
                    class="btn btn-link w-max"
                    @click="$wire.endDate = null">Delete</button>
            @endif

        </div>

        <x-slot:actions>
            <div class="w-10/12 mx-auto">
                <button
                    class="btn btn-info"
                    wire:click="addDate">Save</button>
                <x-button label="Cancel" @click="$wire.cardDateModal = false" />
            </div>
        </x-slot:actions>
    </x-modal>
</div>
