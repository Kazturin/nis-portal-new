<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset("css/swiper-bundle.min.css") }}">
        @livewireStyles
        @vite('resources/css/app.css')

    </head>
    <body>
        <x-layout/>

        @livewireScripts
        @stack('scripts')
    </body>
</html>
