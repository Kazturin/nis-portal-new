@if ($slides)
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto py-16 rounded-xl">
            <x-animate-on-scroll animation="fade-in-up" tag="h2" class="font-inter text-4xl xl:text-5xl mb-16 text-center">
                {{ __('Figures and facts') }}
            </x-animate-on-scroll>

            <x-animate-on-scroll animation="fade-in-left" class="overflow-hidden statistics-slider">
                <div class="swiper-wrapper mb-4">
                    @foreach ($slides as $slide)
                        @include('components.statistics-slider.' . $slide['layout'], ['statistics' => $slide['statistics']])
                    @endforeach
                </div>

                @if (count($slides) > 1)
                    <x-swiper-nav prefix="statistics" />
                @endif
            </x-animate-on-scroll>
        </div>
    </div>
@endif
