<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Загрузка изображения</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="container mx-auto mt-20 mb-4">
        <div class="flex flex-end justify-end">
            <livewire:language-selector />
        </div>
    </div>
   

<livewire:image-checker />

 

    @livewireScripts
</body>

</html>