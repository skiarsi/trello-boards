<?php

use Livewire\Component;

new class extends Component
{
    public $user;
    public $board;
    public $role; // این به wire:model وصل می‌شود

    public function mount($user)
    {
        $this->role = $user->pivot->role ?? '';
    }

    // این متد به محض تغییر مقدار $role به صورت خودکار اجرا می‌شود
    public function updatedRole($value)
    {
        $userId = $this->user->id;

        if($userId === Auth::id() || $this->board->owner_id === $userId) return;

        $this->board->users()->updateExistingPivot($userId, [
            'role' => $value
        ]);

        $this->dispatch('member-updated');
    }
};
?>

<select
    wire:model.live="role"
    wire:loading.attr="disabled"
    class="text-sm border border-gray-300 rounded px-2 py-1 outline-none focus:border-blue-500 disabled:bg-stone-200"
    @if($user->id === Auth::id()) disabled @endif
>
    <option value="editor">Editor</option>
    <option value="viewer">Viewer</option>
    {{-- <option value="owner" disabled>Owner</option> --}}
</select>
