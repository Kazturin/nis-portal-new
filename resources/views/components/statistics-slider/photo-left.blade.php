<div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-10">
    <div class="hidden lg:block">
        <div class="rounded-3xl shadow-md h-full">
            <img src="/img/chapter_bg4.webp" alt="chapter" class="w-full h-full object-cover rounded-xl shadow-md">
        </div>
    </div>
    <div class="h-full">
        @if ($statistic = $statistics->get(0))
            <div class="rounded-3xl shadow-md bg-white px-16 py-9 mb-6">
                <p class="font-inter text-6xl mb-3">{{ $statistic->value }}</p>
                <div class="font-sf text-2xl whitespace-pre-line">{!! $statistic->description !!}</div>
            </div>
        @endif
        @if ($statistic = $statistics->get(1))
            <div class="relative rounded-3xl overflow-hidden shadow-md mb-6">
                <img class="w-full" src="/img/card.png" alt="card">
                <div class="absolute inset-0 text-white px-16 py-9">
                    <p class="font-inter text-6xl text-white mb-4">{{ $statistic->value }}</p>
                    <div class="font-sf text-lg xl:text-2xl text-white whitespace-pre-line">{!! $statistic->description !!}</div>
                </div>
            </div>
        @endif
    </div>
</div>
