<div class="my-6">
    @foreach ($items as $item)
        <details class="mb-4 border border-gray-200 rounded-xl overflow-hidden cursor-pointer bg-white transition-all shadow-sm">
            <summary class="p-4 font-bold text-lg list-none flex items-center justify-between hover:bg-gray-50 bg-[#F0F2F5]">
                <span>{{ $item['title'] }}</span>
                <svg class="w-4 h-4 transition-transform duration-200 icon-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </summary>
            <div class="p-4 border-t border-gray-100 prose max-w-none">
                {!! $item['content'] !!}
            </div>
        </details>
    @endforeach
</div>

<style>
    /* Прячем стандартную стрелку details */
    details > summary::-webkit-details-marker {
        display: none;
    }
    details[open] .icon-arrow {
        transform: rotate(180deg);
    }
</style>
