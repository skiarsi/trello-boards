<div
    x-data="{ open: false }"
    class="select-none relative">

    <div
        @click="open = ! open"
        class="bg-white text-black py-0.5 pt-0 px-5 cursor-pointer"
        >
        <span class="text-sm">{{ Auth::user()->name }}</span>
    </div>
    <div
        x-show="open"
        @click.outside="open = false"
        class="fixed top-10 right-6 bg-white shadow p-2 w-60 rounded-sm border border-stone-200/10">

        {{-- <ul class="p-0"> --}}
            <form method="post" action="{{ route("logout") }}">
                <button type="submit" class="flex gap-2 w-full items-start hover:bg-red-100 py-2 px-1 cursor-pointer">
                    <x-tabler-logout />
                    <span>Logout</span>
                </button>
            </form>
        {{-- </ul> --}}

    </div>
</div>
