<?php

use Livewire\Component;
use App\Notifications\lists\UpdateNotification;
new class extends Component
{
    public $list;

    public array $colors = [
        '#4A90D9',
        '#27AE8F',
        '#7B6FE8',
        '#E8734A',
        '#E85480',
        '#F0A500',
        '#5BAD3A',
        '#eaeaea',
        '#17A589',
        '#6C5CE7',
    ];


    public function mount(){

    }

    public function updatecolor($color){
        if (!in_array($color, $this->colors)) {
            return;
        }

        $user = Auth::user();

        $this->color = $color;

        // Update board in DB
        $this->list->update(['color' => $this->color]);

        $this->dispatch('list-updated');

        $this->list->activeUsers()
                ->each(function($member){
                    $member->notify(new UpdateNotification(
                        list: $this->list,
                        action: 'update-list'
                    ));
                });
    }
};
?>

<div class="grid grid-cols-5 w-full gap-1">
    @foreach ($this->colors as $color)
        <div
            wire:click="updatecolor('{{ $color }}')"
            class="w-full py-1 cursor-pointer opacity-80 hover:opacity-100"
            style="background-color:{{ $color }}">&nbsp;</div>
    @endforeach
</div>
