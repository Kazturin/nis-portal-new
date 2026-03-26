<div class="ornament-card relative rounded-3xl h-full min-h-48" style="background-color: {{ $color }};">
    <img src="/img/ornament-nis.png" alt="" class="absolute bottom-0 right-0 !h-full pt-12 !m-0">
    <div class="p-6 h-full">
        @if ($icon)
            <div class="bg-[#A0D857] p-4 rounded-2xl w-20 h-20 flex items-center justify-center mb-4">
                <img src="/storage/{{ $icon }}" alt="">
            </div>
        @endif
        <div class="prose max-w-none text-base text-black/80 text-left pr-0 md:pr-16">
            {!! $description !!}
        </div>
    </div>
</div>