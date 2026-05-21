<?php

use Livewire\Component;
use App\Notifications\lists\ArchiveLabelNotification;
use Illuminate\Support\Facades\Notification;

new class extends Component
{
    public $list;


    public function archive(){

        $this->list->archived = 1;
        $this->list->save();


        Notification::send(
            $this->list->activeUsers()->get(),
            new ArchiveLabelNotification(
                list: $this->list,
                board: $this->list->board,
                sender:Auth::user(),
            )
        );

        $this->dispatch('list-updated');

    }
};
?>

<div
    @click.stop="
        $wire.archive(),
        show = false
    "
    class="flex gap-2 items-start py-0.5 ps-1 w-full cursor-pointer group">
        <x-heroicon-s-archive-box-arrow-down class="w-4 h-4 mt-1.5 text-gray-500 group-hover:text-gray-400" />
        <span class="block py-1 ps-1 text-sm text-gray-900 group-hover:text-gray-700">Archive this list</span>
</div>
