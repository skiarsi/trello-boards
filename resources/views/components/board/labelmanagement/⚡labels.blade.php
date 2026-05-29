<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Notifications\boards\DeleteLabelNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

new class extends Component
{
    public $labels;
    public $board;
    public $mode = "show";

    public function mount(){
        $this->labels = $this->board->labels;
    }

    #[On('label-created')]
    #[On('label-deleted')]
    public function refreshLabels(){
        $this->labels = $this->board->labels()->get();
    }

    public function deleteLabel($labelid, $labelTitle){
        $label = $this->board->labels()->find($labelid);
        if ($label) {
            $label->delete();
        }

        $this->dispatch('label-deleted');

        Notification::send(
            $this->board->activeUsers()->get(),
            new NewCardNotification(
                board: $this->board,
                label: $labelTitle,
                message: '',
                sender: Auth::user()
            )
        );
    }
};
?>

<div
    @class([
        'grid gap-1 w-full',
        'grid-cols-2' => $this->mode === 'manage',
        'grid-cols-6' => $this->mode !== 'manage',
    ]) class="w-full">

    {{-- اصلاح شرط: استفاده از متغیر داخلی کامپوننت به جای رابطه مستقیم بورد --}}
    @if (count($labels) > 0)
        @foreach ($labels as $label)
            <div
                class="flex gap-2 justify items-start py-1 ps-1"
                style="background-color:{{ $label->color }}"
                wire:key="delete-label-{{ $label->id }}">
                @if($this->mode === "manage")
                    <x-heroicon-o-trash
                        wire:click="deleteLabel({{ $label->id }}, '{{ $label->title }}')"
                        wire:confirm="Are you sure?"
                        class="w-7 h-7 ms-0 p-1 border rounded-full bg-white cursor-pointer" />
                    <span class="text-sm pt-1">{{ $label->title }}</span>
                @endif
            </div>
        @endforeach
    @else
        @if ($this->mode === "manage")
            <p class="text-gray-400 italic text-sm text-center w-full">Create new label from down below form</p>
        @endif
    @endif
</div>
