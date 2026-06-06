<?php

use Livewire\Component;
use App\Models\Checklist;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Notification;
use App\Notifications\checklist\NewChecklistNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $checklists = [];

    public $list;
    public $card;
    public $userRole;

    public $checklisttitle = '';

    public function mount(){
        $this->checklists = $this->card->checklists;
    }

    #[On('checklists-updated')]
    public function refreshChecklists(){
        $this->checklists = $this->card->checklists;
    }

    public function createchecklist(){
        $validate = $this->validate([
            'checklisttitle' => 'required|min:4',
        ]);

        $newChecklist = Checklist::create([
            'card_id' => $this->card->id,
            'title'   => $this->checklisttitle
        ]);

        $this->dispatch('checklists-updated');

        Notification::send(
            $this->list->activeUsers()->get(),
            new NewChecklistNotification(
                cheklist : $newChecklist,
                card: $this->card,
                userId: Auth::id(),
            )
        );

        $this->checklisttitle = '';
    }
};
?>

<div
    x-data="{
                open : false,
                clearandclose(){
                    this.open = false;
                    $wire.checklisttitle = '';
                },
            }"
    @create-new-checklist.window="open = true; $nextTick(()=>{ $refs.checklistinput.focus() })"
    class="W-full mb-5 mt-3 ps-1 max-h-100 overflow-auto {{ $this->checklists ? '' : 'hidden' }}">

    <div
        x-show="open"
        class="mb-4 w-full flex flex-col gap-1" >
            <input
                type="text"
                placeholder="Checklist title..."
                class="input input-md outline-0 w-full"
                wire:model = "checklisttitle"
                wire:keyup.enter="createchecklist"
                x-ref="checklistinput" />

                <div class="flex gap-1 items-start">
                    <button
                        wire:click="createchecklist"
                        class="bg-sky-700 text-white px-4 py-0.5 text-sm cursor-pointer">Create</button>
                    <button
                        @click="clearandclose()"
                        class=" text-black px-4 py-0.5 text-sm cursor-pointer">Cancel</button>
                </div>
    </div>

    @foreach ($this->checklists as $checklist)
        <livewire:cards.checklist.onechecklist
                        :list="$this->list"
                        :card="$this->card"
                        :checklist="$checklist"
                        :userRole="$userRole"
                        wire:key="checklist-{{ $checklist->id }}" />
    @endforeach
</div>
