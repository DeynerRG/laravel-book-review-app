<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Book Review App @yield('page')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
    </head>
    <body class="w-full md:mt-10 flex justify-center items-center bg-gray-100">
        
        <main class="w-full max-w-[800px] overflow-hidden shadow-sm rounded-2xl bg-white text-gray-800">
            
            <div class="p-5">
                @yield('content')
            </div>
        </main>
    </body>
</html>
