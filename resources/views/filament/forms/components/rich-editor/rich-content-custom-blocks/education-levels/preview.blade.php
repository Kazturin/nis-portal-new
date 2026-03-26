<div class="p-4 bg-gray-50 border border-dashed border-gray-300 rounded-lg flex flex-col gap-2">
    <div class="text-sm font-semibold uppercase text-gray-500">Уровни образования (Блок)</div>
    @if(!empty($items))
        <div class="flex gap-2">
            @foreach($items as $item)
                <div class="px-3 py-1 bg-white border border-gray-200 rounded flex gap-2 items-center">
                    <span class="font-bold text-gray-700">{{ $item['range'] }}</span>
                    <span class="text-xs text-gray-500">{{ $item['unit'] }}</span>
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                    <span class="text-sm font-medium">{{ $item['title'] }}</span>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-400 italic">Элементы не настроены</div>
    @endif
</div>
