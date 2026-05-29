<?php

use Livewire\Component;
use App\Models\Boardlist;
use Livewire\Attributes\On;
use App\Notifications\lists\UpdateNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[Reactive]
    public $collapsed;

    public $list;
    public $userRole;
    public $class;

    public $title;
    public $show = false;

    #[On('list-updated')]
    public function mount(){

        $this->title = $this->list->title;
    }


    public function updatelisttitl(){
        if($this->list->title === $this->title){
            return;
        }

        $this->validate([
            'title' => 'required|string|min:3|max:50'
        ]);

        $this->list->update([
            'title' => $this->title
        ]);

        $this->dispatch('list-updated');

        Notification::send(
            $this->list->activeUsers()->get(),
            new UpdateNotification(
                list: $this->list,
                action: 'update-list',
                sender: Auth::user()
            ),
        );
    }

};
?>

<div
    class="flex flex-col w-full"
    x-data="{
        show: false,
        editandfocus(){
            this.show = true;
            this.$nextTick(() => {
                this.$refs.input.focus();
                this.$refs.input.select();
            });
        },
        cleanandclose(){
            this.show = false
        },
        listId: {{ $this->list->id }}
    }"
    @open-rename.window="
        show = ($event.detail.listId === listId) ? !show : false;
        if(show) $nextTick(()=> { $refs.input.focus(); $refs.input.select(); })
    ">
    <div class="flex-1 w-full">
        <p
            x-show = "!show"
            @click="editandfocus()"
            class="{{ $this->class }} {{ $this->collapsed ? 'w-20' : 'w-auto' }} cursor-pointer select-none py-0.5 px-1 mb-0.5 text-[1.1rem] text-black truncate">
                {{ $this->title }}
        </p>
        <input
            x-show="show"
            x-ref="input"
            @click.outside="
                $wire.updatelisttitl()
                    .then(()=>{
                        cleanandclose();
                    });"
            @keydown.escape="cleanandclose()"
            @keydown.enter="
                $wire.updatelisttitl()
                    .then(()=>{
                        cleanandclose();
                    });
            "
            type="text"
            wire:model.lazy="title"
            class="w-11/12 mb-1 bg-stone-200 outline-0 text-lg text-black px-1 rounded-sm border border-stone-300" />
    </div>
</div>
