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
    }
};
?>

<div
        x-data="{
            collapsed : @js($this->list->collapsed)
        }"
        class="{{ $this->list->collapsed ? 'w-36' : 'w-68' }} shrink-0 pt-2 shadow pb-0 px-2 flex flex-col rounded-sm"
        style="background:{{ $this->list->color }}"
    >

    <div class="w-full flex justify-between bg-white px-2 py-1 rounded-lg {{ $list->cards->count() === 0 ? 'mb-2' : '' }}">
        {{-- list title component --}}
        <livewire:lists.head.title
            :class="$this->list->collapsed ? 'cursor-default pb-0.5 select-none' : ''"
            :list="$this->list"
            />


        <div class="flex gap-2">
            {{-- collapse component --}}
            <livewire:lists.head.collapse :list="$this->list" :collapse="$this->list->collapsed" />

            @if ($this->userRole !== 'viewer' && !$this->list->collapsed)
                {{-- options components --}}
                <livewire:lists.head.options :list="$this->list" />
            @endif

       </div>
    </div>

    <livewire:lists.setting.addlabel :list="$this->list" />

    @if (!$this->list->collapsed)
        <div class="w-full">

            @if ($this->userRole !== 'viewer' && !$this->list->collapsed)
                <livewire:cards.newcard :board="$this->board" :list="$list" />

            @endif

            @if ($list->cards->count() > 0)
                <hr class="border border-gray-300 mx-auto my-4 w-10/12" />

                <livewire:cards.allcards :board="$this->board" :list="$list" :userRole="$userRole" />
            @endif

        </div>
    @endif
</div>
