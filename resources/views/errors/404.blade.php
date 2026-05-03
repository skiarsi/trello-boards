{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '404 - Page Not Found')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full">
    <div class="flex flex-col gap-3 w-full h-screen">

        <div class="px-2 py-1 w-full">
            <livewire:topheader.header />
        </div>
        <div class="px-2 w-full flex gap-2 items-start h-full">
            <livewire:leftside.main />

            <div class="flex-1 bg-stone-200 h-full flex flex-col justify-center align-middle items-center">
                <h1 class="text-8xl block">404</h1>
                <p class="text-xl -mt-1 block">Page not founds!!!</p>
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
