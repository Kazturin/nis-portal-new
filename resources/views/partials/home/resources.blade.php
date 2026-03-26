@php($locale = app()->getLocale())

<div class="px-4 xl:px-0 mb-24">
    <x-animate-on-scroll animation="fade-in-left" class="w-full xl:max-w-6xl mx-auto my-16">
        <p class="font-inter text-4xl xl:text-5xl mb-5 text-center">{{ $resources_block->{'title_' . $locale} }}</p>
    </x-animate-on-scroll>

    <x-animate-on-scroll animation="fade-in-right" class="my-10">
        <div class="overflow-hidden resource-slider swiper-no-mousewheel">
            <div class="swiper-wrapper flex items-stretch mb-11">
                @foreach ($resources as $resource)
                    <div class="swiper-slide">
                        <div class="h-[450px] rounded-2xl overflow-hidden shadow-md flex flex-col">
                            <div class="h-48 flex-shrink-0">
                                <img class="block w-full h-full object-cover" src="{{ $resource->getThumbnail() }}"
                                    alt="resource">
                            </div>
                            <div class="bg-gray-100 px-7 pt-8 pb-8 flex-1 flex flex-col justify-between">
                                <div class="relative group">
                                    <div class="font-inter mb-2 text-xl line-clamp-2"
                                        title="{{ strip_tags($resource->{'description_' . $locale}) }}">
                                        {{ $resource->{'title_' . $locale} }}</div>
                                    <div class="font-sf text-lg text-[#333333] leading-6 line-clamp-3 cursor-auto">
                                        {!! $resource->{'description_' . $locale} !!}
                                    </div>
                                    <div
                                        class="absolute invisible group-hover:visible z-20 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white p-2 rounded-lg text-sm w-64 -top-full left-0">
                                        {!! $resource->{'description_' . $locale} !!}
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a class="font-sf py-2 px-4 bg-primary hover:bg-[#67A600] text-white rounded-3xl"
                                        href="{{ $resource->link }}" target="_blank">{{ __('More') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <x-swiper-nav prefix="resource" />
        </div>
    </x-animate-on-scroll>
</div>