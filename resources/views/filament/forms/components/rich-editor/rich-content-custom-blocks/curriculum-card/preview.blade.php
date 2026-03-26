<div class="p-4 bg-gray-50 border border-dashed border-gray-300 rounded-lg flex flex-col gap-2">
    <div class="text-sm font-semibold uppercase text-gray-500">Карточка программы (Блок)</div>
    @if(!empty($top_label))
        <div class="text-xs font-bold text-gray-400">{{ $top_label }}</div>
    @endif
    <div class="w-full h-4 rounded-full" style="background-color: {{ $background_color }}"></div>
    <div class="text-sm font-medium text-gray-700 truncate">
        {!! strip_tags($content) !!}
    </div>
</div>
