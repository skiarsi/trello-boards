<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Boardlist;
use App\Notifications\lists\UpdateNotification;

new class extends Component
{
    public $list;
    public $board;
    public $listId;
    public $userRole;

    #[On('list-updated')]
    public function mount(){
        $this->listId = $this->list->id;

    }

    public function collapsing(){
        $list = Boardlist::find($this->listId);

        $list->update([
            'collapsed' => !$list->collapsed
        ]);

        $this->list = $list->fresh();

        $this->board->activeUsers()
                        ->each(function($members) use ($list){
                            $members->notify(new UpdateNotification(
                                list: $this->list
                            ));
                        });
    }
};
?>

<div
        x-data="{
            collapsed : @js($this->list->collapsed)
        }"
        class="{{ $this->list->collapsed ? 'w-36' : 'w-68' }} shrink-0 pt-0.5 pb-0 px-2 flex flex-col shadow rounded-sm"
        style="background:{{ $this->list->color }}"
    >

    <div class="w-full flex justify-between">
        {{-- list title component --}}
        <livewire:lists.head.title
            :class="$this->list->collapsed ? 'cursor-default select-none' : ''"
            :title="$this->list->title" />


        <div class="flex gap-2">
            {{-- collapse component --}}
            <livewire:lists.head.collapse :collapse="$this->list->collapsed" />

            @if (!$this->list->collapsed)
                {{-- options components --}}
                <livewire:lists.head.options />
            @endif

       </div>
    </div>
    @if (!$this->list->collapsed)
        <div class="w-full">

            @if ($this->userRole !== 'viewer' && !$this->list->collapsed)
                <livewire:cards.newcard :list="$list" />
            @endif

            <livewire:cards.allcards :list="$list" />

        </div>
    @endif
</div>
