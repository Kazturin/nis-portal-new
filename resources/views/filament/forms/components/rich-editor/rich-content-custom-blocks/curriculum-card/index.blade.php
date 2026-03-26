<div class="not-prose mb-4 w-full h-full flex flex-col items-center">
    @if(!empty($top_label))
        <div class="mb-4 text-center">
            <span class="text-sm md:text-base font-bold text-[#7E8487] uppercase tracking-[0.1em] font-inter">
                {{ $top_label }}
            </span>
        </div>
    @endif

    <div class="relative w-full rounded-2xl p-5 md:p-8 transition-all duration-300 shadow-sm hover:shadow-md h-full min-h-[300px]"
        style="background-color: {{ $background_color ?? '#BEE98F' }};">

        {{-- Arrow Pin --}}
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 8L13 1" stroke="{{ $background_color ?? '#BEE98F' }}" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        {{-- Content --}}
        <div class="rich-content-wrapper font-inter space-y-6 !text-base">
            {!! $content !!}
        </div>
    </div>
</div>