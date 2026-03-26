<div class="bg-gray-100 py-4">
    <div class="container mx-auto py-16 rounded-xl">
        <x-animate-on-scroll animation="fade-in-up" tag="h2" class="font-inter text-4xl xl:text-5xl mb-16 text-center">
            {{ __("Figures and facts") }}
        </x-animate-on-scroll>

        <x-animate-on-scroll animation="fade-in-left" class="overflow-hidden statistics-slider">
            <div class="swiper-wrapper mb-10">
                {{-- Slide 1 --}}
                <div class="swiper-slide grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10">
                    <div class="flex flex-col">
                        <div class="mb-6 hidden lg:block">
                            <img src="/img/chapter_bg.webp" alt="chapter" class="w-full h-[330px] object-cover rounded-xl shadow-md">
                        </div>
                        <div class="flex-1 rounded-3xl overflow-hidden shadow-md">
                            <div style="background-image: url('/img/card.png');" class="h-full text-white p-6 lg:p-12">
                                <div class="flex items-center space-x-6 mb-6 lg:mb-14">
                                    <p class="font-inter text-3xl xl:text-6xl text-nowrap">17 884</p>
                                    <div class="text-sf text-lg xl:text-2xl">{!! $statistics['17 884']?->description !!}</div>
                                </div>
                                <div class="flex items-center space-x-6 mb-3 xl:mb-6">
                                    <p class="font-inter text-2xl xl:text-4xl text-nowrap">1891 / 11%</p>
                                    <div class="font-sf text-xl">{!! $statistics['1891 / 11%']?->description !!}</div>
                                </div>
                                <div class="flex items-center space-x-6">
                                    <p class="font-inter text-2xl xl:text-4xl text-nowrap">5 985 / 38,4%</p>
                                    <div class="font-sf text-xl">{!! $statistics['5 985 / 38,4%']?->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white p-6 lg:p-12 rounded-3xl shadow-md h-full">
                            <p class="font-inter text-4xl xl:text-6xl mb-2 lg:mb-6">2702</p>
                            <div class="text-sf text-base xl:text-2xl leading-7">{!! $statistics['2702']?->description !!}</div>
                        </div>
                    </div>
                </div>

                {{-- Slide 2 --}}
                <div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-10">
                    <div>
                        <div class="h-fit rounded-3xl overflow-hidden shadow-md mb-6">
                            <div style="background-image: url('/img/card.png');" class="h-fit text-white px-8 py-4 lg:px-16 lg:py-9">
                                <p class="font-inter text-4xl lg:text-6xl text-white">20 771</p>
                                <div class="text-sf text-lg xl:text-2xl text-white whitespace-pre-line">{!! $statistics['20 771']?->description !!}</div>
                            </div>
                        </div>
                        <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
                            <p class="font-inter text-4xl xl:text-6xl mb-3">220</p>
                            {!! $statistics['220']?->description !!}
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="rounded-3xl shadow-md h-full">
                            <img src="/img/chapter_bg2.webp" alt="chapter" class="w-full h-full object-cover rounded-xl shadow-md">
                        </div>
                    </div>
                </div>

                {{-- Slide 3 --}}
                <div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-10">
                    <div class="relative rounded-3xl overflow-hidden shadow-md">
                        <img class="w-full" src="/img/card.png" alt="card">
                        <div class="absolute inset-0 text-white px-8 py-4 lg:px-16 lg:py-9">
                            <p class="font-inter text-4xl lg:text-6xl text-white mb-4">7,0</p>
                            <div class="font-sf text-lg lg:text-2xl text-white whitespace-pre-line">{!! $statistics['7,0']?->description !!}</div>
                        </div>
                    </div>
                    <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
                        <p class="font-inter text-3xl lg:text-6xl mb-3">348 465</p>
                        <div class="font-sf text-2xl whitespace-pre-line">{!! $statistics['348 465']?->description !!}</div>
                    </div>
                    <div class="rounded-3xl shadow-md bg-white px-8 py-4 lg:px-16 lg:py-9">
                        <p class="font-inter text-4xl lg:text-6xl mb-3">91,8 %</p>
                        <div class="font-sf text-xl lg:text-2xl whitespace-pre-line">{!! $statistics['91,8 %']?->description !!}</div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="rounded-3xl shadow-md h-full">
                            <img src="/img/chapter_bg3.webp" alt="chapter" class="w-full max-h-96 object-cover rounded-xl shadow-md">
                        </div>
                    </div>
                </div>

                {{-- Slide 4 --}}
                <div class="swiper-slide grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="hidden lg:block">
                        <div class="rounded-3xl shadow-md h-full">
                            <img src="/img/chapter_bg4.webp" alt="chapter" class="w-full h-full object-cover rounded-xl shadow-md">
                        </div>
                    </div>
                    <div class="h-full">
                        <div class="rounded-3xl shadow-md bg-white px-16 py-9 mb-6">
                            <p class="font-inter text-6xl mb-3">22</p>
                            <div class="font-sf text-2xl whitespace-pre-line">{!! $statistics['22']?->description !!}</div>
                        </div>
                        <div class="relative rounded-3xl overflow-hidden shadow-md mb-6">
                            <img class="w-full" src="/img/card.png" alt="card">
                            <div class="absolute inset-0 text-white px-16 py-9">
                                <p class="font-inter text-6xl text-white mb-4">1299</p>
                                <div class="font-sf text-lg xl:text-2xl text-white whitespace-pre-line">{!! $statistics['1299']?->description !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-swiper-nav prefix="statistics" />
        </x-animate-on-scroll>
    </div>
</div>
