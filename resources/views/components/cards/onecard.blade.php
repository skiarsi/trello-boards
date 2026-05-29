<div class="w-full">

        <span onclick="document.getElementById('modal-{{ $card->id }}').showModal()" class="flex-1 block select-none">
            {{ $card->title }}
        </span>


    <dialog id="modal-{{ $card->id }}" class="modal cursor-default">
        <div class="modal-box w-11/12 max-w-5xl" style="background:#fafafa; {{ $card->color ? 'border-top: 2rem solid '.$card->color.'' : ''  }}" >
            <div class="flex justify-between w-full border-b border-gray-200 overflow-hidden">
                <h3 class="text-xl font-bold">{{ $card->title }}</h3>
                <span onclick="document.getElementById('modal-{{ $card->id }}').close()"
                        class="py-0 -mt-4 text-5xl font-extralight text-gray-700 cursor-pointer select-none hover:text-black">&times;</span>
            </div>


            <div class="flex w-full">
                <div class="flex-1 py-3 px-2">
                    <livewire:cards.content.bar :userRole="$userRole" :card="$card" :list="$list" />
                    <livewire:cards.content.description :card="$card" :list="$list" />
                </div>
                <div class="w-5/12 py-3 border-l border-gray-200">
                    <livewire:cards.comments.newcomment :card="$card" :list="$list" />
                    {{-- <livewire:cards.comments.allcomments :card="$card" /> --}}
                </div>
            </div>
        </div>
    </dialog>
</div>
