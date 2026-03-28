<div class="not-prose mb-12 w-full hidden lg:block">
    <div class="flex flex-wrap items-end justify-center gap-6 md:gap-8 overflow-x-auto pb-4">
        @foreach($items as $index => $item)
            @php
                // Increasing heights based on index
                $height = 160 + ($index * 40);
                $bgColor = $item['color'] ?? '#FDE68A';
            @endphp
            <div
                class="flex flex-col items-center w-full max-w-[280px] group transition-transform duration-300 hover:-translate-y-2">
                {{-- Range and Unit --}}
                <div class="flex items-baseline gap-1 mb-4 text-[#7E8487] font-sans">
                    <span
                        class="text-6xl md:text-7xl font-inter-regular font-medium tracking-tighter mr-1">{{ $item['range'] }}</span>
                    <span class="text-lg md:text-xl font-inter pb-2">{{ $item['unit'] }}</span>
                </div>

                {{-- Colored Card --}}
                <div class="w-full rounded-t-[2rem] p-8 flex flex-col items-center justify-start text-center transition-all duration-300 shadow-sm hover:shadow-md"
                    style="background-color: {{ $bgColor }}; height: {{ $height }}px;">
                    <p class="text-xl md:text-xl text-left font-inter text-gray-900 leading-tight">
                        {{ $item['title'] }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>