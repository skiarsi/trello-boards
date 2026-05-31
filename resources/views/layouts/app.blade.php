<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title ?? config('app.name') }}</title>

        @auth
            <script>
                window.authUserId = {{ auth()->user()?->id }};
            </script>
        @endauth

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- EasyMDE --}}
        <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
        <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@3.1.0/index.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@3.1.0/styles/index.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-screen w-full">

        <div class="flex flex-col gap-3 w-full h-screen">
            <div class="px-2 py-1 w-full">
                <livewire:topheader.header />
            </div>
            <div class="px-2 w-full flex gap-2 items-start h-full max-h-full overflow-hidden ">
                <livewire:leftside.main />

                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
