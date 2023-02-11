<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sleepwell</title>

        <style>[x-cloak] { display: none !important; }</style>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
        @stack('scripts')

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-amber-50">
{{--            @include('layouts.navigation')--}}

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewire('notifications')
    </body>
</html>
