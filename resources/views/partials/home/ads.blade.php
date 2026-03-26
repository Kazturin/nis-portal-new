<div class="my-20">
    <x-animate-on-scroll animation="scale-in" class="overflow-hidden ad-slider">
        <div class="swiper-wrapper flex items-stretch mb-10">
            @foreach ($ads as $ad)
                <div class="swiper-slide px-4 lg:px-0">
                    <a href="{{ $ad->getLink() }}" target="_blank" class="block h-[400px]">
                        <img class="block w-full h-full object-cover rounded-2xl shadow-lg" src="{{ $ad->getBanner() }}"
                            alt="ad">
                    </a>
                </div>
            @endforeach
        </div>
        <x-swiper-nav prefix="ad" />
    </x-animate-on-scroll>
</div>