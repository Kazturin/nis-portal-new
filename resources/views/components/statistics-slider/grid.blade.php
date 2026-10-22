<div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-10">
    @if ($statistic = $statistics->get(0))
        <div class="relative rounded-3xl overflow-hidden shadow-md">
            <img class="w-full" src="/img/card.png" alt="card">
            <div class="absolute inset-0 text-white px-8 py-4 lg:px-16 lg:py-9">
                @if (filled($statistic->value))
                    <p class="font-inter text-4xl lg:text-6xl text-white mb-4">{{ $statistic->value }}</p>
                @endif
                <div class="font-sf text-lg lg:text-2xl text-white whitespace-pre-line">{!! $statistic->description !!}</div>
            </div>
        </div>
    @endif
    @if ($statistic = $statistics->get(1))
        <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
            @if (filled($statistic->value))
                <p class="font-inter text-3xl lg:text-6xl mb-3">{{ $statistic->value }}</p>
            @endif
            <div class="font-sf text-2xl whitespace-pre-line">{!! $statistic->description !!}</div>
        </div>
    @endif
    @if ($statistic = $statistics->get(2))
        <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
            @if (filled($statistic->value))
                <p class="font-inter text-4xl lg:text-6xl mb-3">{{ $statistic->value }}</p>
            @endif
            <div class="font-sf text-xl lg:text-2xl whitespace-pre-line">{!! $statistic->description !!}</div>
        </div>
    @endif
    <div class="hidden lg:block">
        <div class="rounded-3xl shadow-md h-full">
            <img src="/img/chapter_bg3.webp" alt="chapter" class="w-full max-h-96 object-cover rounded-xl shadow-md">
        </div>
    </div>
</div>
