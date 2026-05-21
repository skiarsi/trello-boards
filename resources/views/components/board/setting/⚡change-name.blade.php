<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Computed;
use App\Notifications\boards\BoardUpdateNotification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[Modelable]
    public $title;

    public $userRole;

    public $board;

    // update board title
    public function updateTitle(){


        // don't update with same name
        if ($this->board->title === $this->title) {
            return;
        }

        $this->validate([
            'title' => 'required|string|min:3|max:50'
        ]);



        // update on database
        $this->board->update([
            'title' => $this->title
        ]);

        $this->board->activeUsers()
                    ->each(function($member){
                        $member->notify(new BoardUpdateNotification(
                            board : $this->board,
                            action : 'title_changed',
                            message : 'Board `'.$this->board->slug.'` title is changed.',
                            sender : Auth::user()
                        ));
                    });
    }

    public function mount(){

    }
};
?>

<div
    x-data="{
        editing : false,
        initialValue: '',
        startEditing() {
            this.initialValue = $wire.title;
            this.editing = true;
            $nextTick(() => {
                $refs.input.focus();
                $refs.input.select();
            });
        },
        save() {
            if (!this.editing) return;

            if ($wire.title !== this.initialValue) {
                $wire.updateTitle().then(() => {
                    document.title = $wire.title;
                    this.editing = false;
                });
            } else {
                this.editing = false;
            }
        },
        cancel() {
            $wire.title = this.initialValue;
            this.editing = false;
        }
    }"
    class="flex items-center"
>
    @if ($this->userRole === 'viewer')
        <span class="text-white text-lg cursor-default">
            {{ $title }}
        </span>
    @else
        <span
            x-show="!editing"
            @click="startEditing()"
            class="text-white text-lg cursor-pointer"
        >
            {{ $title }}
        </span>

        <input
            type="text"
            x-show="editing"
            x-ref="input"
            wire:model="title"
            @click.outside="save()"
            @keydown.enter="save()"
            @keydown.escape="cancel()"
            class="py-0.5 px-2 bg-white text-black rounded-none outline-0"
        />
    @endif
</div>
