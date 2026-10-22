<div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-10">
    <div>
        @if ($statistic = $statistics->get(0))
            <div class="h-fit rounded-3xl overflow-hidden shadow-md mb-6">
                <div style="background-image: url('/img/card.png');" class="h-fit text-white px-8 py-4 lg:px-16 lg:py-9">
                    <p class="font-inter text-4xl lg:text-6xl text-white">{{ $statistic->value }}</p>
                    <div class="text-sf text-lg xl:text-2xl text-white whitespace-pre-line">{!! $statistic->description !!}</div>
                </div>
            </div>
        @endif
        @if ($statistic = $statistics->get(1))
            <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
                <p class="font-inter text-4xl xl:text-6xl mb-3">{{ $statistic->value }}</p>
                {!! $statistic->description !!}
            </div>
        @endif
    </div>
    <div class="hidden lg:block">
        <div class="rounded-3xl shadow-md h-full">
            <img src="/img/chapter_bg2.webp" alt="chapter" class="w-full h-full object-cover rounded-xl shadow-md">
        </div>
    </div>
</div>
