<div class="p-4 bg-gray-50 border border-gray-200 rounded-lg flex items-center gap-4">
    <div class="flex-grow">
        <div class="flex items-center gap-2">
            <x-heroicon-o-code-bracket class="w-4 h-4 text-gray-500" />
            <p class="text-sm font-medium text-gray-700">Iframe (Вставка) @if($is_video ?? false)<span class="ml-1 text-[10px] uppercase font-bold tracking-wider bg-red-100 text-red-600 px-2 py-0.5 rounded">Видео</span>@endif</p>
        </div>
        <p class="text-xs text-gray-500 truncate mt-1">{{ $url ?? 'Нет ссылки' }} @if(!($is_video ?? false))({{ $height }})@endif</p>
    </div>
</div>
