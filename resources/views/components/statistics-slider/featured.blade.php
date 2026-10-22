<div class="swiper-slide grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
    <div class="flex flex-col {{ $statistics->count() < 4 ? 'lg:col-span-2' : '' }}">
        <div class="mb-6 hidden lg:block">
            <img src="/img/chapter_bg.webp" alt="chapter" class="w-full h-[330px] object-cover rounded-xl shadow-md">
        </div>
        <div class="flex-1 rounded-3xl overflow-hidden shadow-md">
            <div style="background-image: url('/img/card.png');" class="h-full text-white p-6 lg:p-12">
                @foreach ($statistics->take(3) as $statistic)
                    <div @class([
                        'flex items-center space-x-6',
                        'mb-6 lg:mb-14' => $loop->first && ! $loop->last,
                        'mb-3 xl:mb-6' => ! $loop->first && ! $loop->last,
                    ])>
                        <p @class([
                            'font-inter text-nowrap',
                            'text-3xl xl:text-6xl' => $loop->first,
                            'text-2xl xl:text-4xl' => ! $loop->first,
                        ])>{{ $statistic->value }}</p>
                        <div @class([
                            'text-sf text-lg xl:text-2xl' => $loop->first,
                            'font-sf text-xl' => ! $loop->first,
                        ])>{!! $statistic->description !!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if ($statistic = $statistics->get(3))
        <div>
            <div class="bg-white p-6 lg:p-12 rounded-3xl shadow-md h-full">
                <p class="font-inter text-4xl xl:text-6xl mb-2 lg:mb-6">{{ $statistic->value }}</p>
                <div class="text-sf text-base xl:text-2xl leading-7">{!! $statistic->description !!}</div>
            </div>
        </div>
    @endif
</div>
