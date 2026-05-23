<div class="w-full">
    <span onclick="document.getElementById('modal-{{ $card->id }}').showModal()" class="flex-1 block">
        {{ $card->title }}
    </span>

    <dialog id="modal-{{ $card->id }}" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="text-lg font-bold">{{ $card->title }}</h3>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</div>
