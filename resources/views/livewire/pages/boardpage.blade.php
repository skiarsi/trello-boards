<div class="flex flex-col gap-3 w-full h-screen">
    <div class="px-2 py-1 w-full">
        <livewire:topheader.header />
    </div>
    <div class="px-2 w-full flex gap-2 items-start h-full max-h-full overflow-hidden">
        <livewire:leftside.main />

        <livewire:container.boardslist :userRole="$userRole" :board="$board" />
    </div>
</div>
