<?php

use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\lists\DeleteListLabelNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $label;
    public $list;
    public $userRole;

    public function deletelabel($labelId){

        if($this->userRole !== 'viewer'){
            $this->label->where('id', $labelId)->delete();

            $this->dispatch('listlable-updated');

            Notification::send(
                $this->list->activeUsers()->get(),
                new DeleteListLabelNotification(
                    list: $this->list,
                    sender: Auth::user()
                )
            );
        }
    }
};
?>

<x-popover position="top-start" >
    <x-slot:trigger class="w-full">
        <div
            class="select-none w-full h-2 rounded-full shadow"
            style="background-color:{{ $this->label->color }}"
                @if($this->userRole !== 'viewer')
                    @dblclick="if (confirm('Are you sure you want to delete this label?')) $wire.deletelabel('{{ $label->id }}')"
                @endif
            >
                &nbsp;
        </div>
    </x-slot:trigger>
    <x-slot:content class="border w-40 text-sm py-1 px-3 bg-stone-950 text-white">
        {{ $this->label->title }}
    </x-slot:content>
</x-popover>
