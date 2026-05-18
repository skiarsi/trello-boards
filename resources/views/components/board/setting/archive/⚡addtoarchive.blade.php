<?php

use Livewire\Component;
use App\Notifications\boards\BoardUpdateNotification;

new class extends Component
{
    public $board;


    public function archiveBoard(){

        // $this->dispatch("board-updated", boardId: $this->board->id);
        $this->board->activeUsers()
                    ->each(function($member){
                        $member->notify(new BoardUpdateNotification(
                            board : $this->board,
                            action : 'archived',
                            message : 'Board `'.$this->board->title.'` is archived.'
                        ));
                    });

        $this->board->is_archive = true;
        $this->board->save();
        $this->board->refresh();



        return $this->redirect('/', navigate: true);
    }
};
?>
<div
    class="w-full"
    x-data="{ open : false }">
    <div
        class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group"
        @click="open = true"
        >
            <x-heroicon-s-archive-box-arrow-down class="W-43 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
            <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Archive this board</span>
    </div>

    <div
        x-show="open"
        @click.outside="open = !open"
        class="pb-3 px-2">

        <p class="text-sm italic text-gray-700">Are you sure, You want to archive the board?</p>

        <div class="w-full flex gap-2">
            <button
                @click="$wire.archiveBoard()"
                class="py-0.5 px-4 bg-indigo-800 text-white text-sm shadow">Archive</button>
            <button class="py-0.5 px-4 bg-gray-200 text-black text-sm shadow" @click="open = false">Cancel</button>
        </div>

    </div>
</div>
