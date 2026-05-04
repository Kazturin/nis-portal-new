<div class="p-4 bg-gray-50 border border-gray-200 rounded-lg flex items-center gap-4">
    <div class="flex-grow">
        <div class="flex items-center gap-2">
            <x-heroicon-o-code-bracket class="w-4 h-4 text-gray-500" />
            <p class="text-sm font-medium text-gray-700">Iframe (Вставка)</p>
        </div>
        <p class="text-xs text-gray-500 truncate">{{ $url ?? 'Нет ссылки' }} ({{ $height }})</p>
    </div>
</div>
