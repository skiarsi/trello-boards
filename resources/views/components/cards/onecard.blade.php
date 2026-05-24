<div class="w-full">
    <span onclick="document.getElementById('modal-{{ $card->id }}').showModal()" class="flex-1 block">
        {{ $card->title }}
    </span>

    <dialog id="modal-{{ $card->id }}" class="modal cursor-default">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="text-lg font-bold border-b border-gray-200">{{ $card->title }}</h3>

            <div class="flex w-full">
                <div class="flex-1 py-3">&nbsp;</div>
                <div class="w-5/12 bg-stone-100 py-3 border-l border-gray-200">
                    <livewire:cards.comments.newcomment />
                    <livewire:cards.comments.allcomments :card="$card" />
                </div>
            </div>

            <div class="modal-action py-0 mt-4">
                <button onclick="document.getElementById('modal-{{ $card->id }}').close()"
                        class="py-1 px-2 my-0 text-lg text-gray-700 cursor-pointer border-none outline-0 select-none hover:text-black">Close</button>
            </div>
        </div>
    </dialog>
</div>
