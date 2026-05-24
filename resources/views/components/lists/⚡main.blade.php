<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Boardlist;

new class extends Component
{
    public $list;
    public $board;
    public $listId;
    public $userRole;

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
        class="{{ $this->list->collapsed ? 'w-36' : 'w-68' }} shrink-0 pt-2 pb-2 shadow px-2 flex flex-col rounded-sm"
        style="background:{{ $this->list->color }}"
    >

    <div class="w-full flex justify-between bg-white px-2 py-1 rounded-lg {{ $list->cards->count() === 0 ? 'mb-2' : '' }}">

        <div class="flex flex-col w-full">
        {{-- list title component --}}
        <livewire:lists.head.title
            :collapsed="$this->list->collapsed"
            :class="$this->list->collapsed ? 'cursor-default pb-0.5 select-none' : ''"
            :list="$this->list"
            :userRole="$this->userRole"
            />

        <livewire:lists.head.labels :list="$this->list" :userRole="$userRole" />

        </div>

        <div class="flex gap-2 ">
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

            <livewire:cards.allcards :board="$this->board" :list="$list" :userRole="$userRole" />

        </div>
    @endif
</div>
