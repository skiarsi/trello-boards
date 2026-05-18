<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\boards\BoardUpdateNotification;

new class extends Component
{
    public $board;

    public $color;

    public array $colors = [
        '#B5D4F4',
        '#9FE1CB',
        '#CECBF6',
        '#F5C4B3',
        '#F4C0D1',
        '#FAC775',
        '#C0DD97',
        '#D3D1C7',
        '#5DCAA5',
        '#AFA9EC',
    ];

    public function updatecolor($color){
        if (!in_array($color, $this->colors)) {
            return;
        }

        $user = Auth::user();

        $this->color = $color;

        // Update board in DB
        $this->board->update(['color' => $this->color]);

        // for close menu
        $this->dispatch('close-dropdown');



        // for change board's color for board owner
        // $this->dispatch('board-updated', boardId: $this->board->id);

        // get members of board ans send notify them to update board
        $this->board->activeUsers()
                    ->each(function($member){
                        $member->notify(new BoardUpdateNotification(
                            board : $this->board,
                            action : 'color_change',
                            message : 'Board `'.$this->board->title.'` color is changed.'
                        ));
                    });
    }
};
?>

<div class="grid grid-cols-5 w-full gap-1">
    @foreach ($colors as $color)
        <div
            @click="$wire.updatecolor('{{ $color }}')"
            class="w-full py-1 cursor-pointer opacity-80 hover:opacity-100"
            style="background-color:{{ $color }}">&nbsp;</div>
    @endforeach
</div>
