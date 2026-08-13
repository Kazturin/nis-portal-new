<div class="p-4 border border-dashed border-gray-300 rounded-lg text-center text-gray-500 bg-gray-50">
    <div class="flex items-center justify-center gap-2 mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
        <span class="font-semibold text-gray-700">Блок вкладок (Tabs)</span>
    </div>
    
    <div class="text-sm">
        @if (isset($tabs) && count($tabs) > 0)
            <ul class="list-disc list-inside text-left inline-block">
                @foreach($tabs as $tab)
                    <li>{{ $tab['title'] ?? 'Без заголовка' }}</li>
                @endforeach
            </ul>
        @else
            Количество вкладок: {{ count($tabs ?? []) }}
        @endif
    </div>
</div>
