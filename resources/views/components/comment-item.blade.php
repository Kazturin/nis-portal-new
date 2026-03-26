@props([
    'comment',
    'author',
    'image',
])

<div class="flex items-center"> 
    <img class="w-10 h-10 rounded-full" src="{{ $image }}" alt="avatar">
    <div class="ml-4">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $author }}</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment }}</p>
    </div>
</div>