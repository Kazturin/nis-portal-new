@php($locale = app()->getLocale())

<div class="container mx-auto mb-24 mt-12">
    <div>
        <x-animate-on-scroll animation="fade-in-left" class="font-inter text-4xl xl:text-5xl text-center mb-10">
            <a href="{{ route('news', $locale) }}">{{ __("News") }}</a>
        </x-animate-on-scroll>

        <div>
            <x-animate-on-scroll animation="fade-in-right" class="flex lg:max-h-[588px] flex-col lg:flex-row">
                <div class="relative w-full lg:w-7/12">
                    <img class="w-full h-full rounded-3xl object-cover" src="{{ $mainNews->getPhoto() }}" alt="news">
                    <div class="block lg:hidden">
                        @include('partials.news-main', ['news' => $mainNews])
                    </div>
                </div>
                <div class="w-full lg:w-5/12 px-4">
                    @foreach($sideNews as $val)
                        <div class="flex flex-col lg:flex-row space-x-2 rounded-3xl overflow-hidden lg:h-1/4">
                            <img class="flex-shrink-0 w-full lg:w-4/12 rounded-xl h-full object-cover px-1 py-2" src="{{ $val->getPhoto() }}" alt="">
                            <div class="flex-1 py-2">
                                <a href="{{ route('news.show', ['locale' => $locale, 'news' => $val]) }}">
                                    <p class="font-sf font-semibold text-xl">{{ $val->shortTitle(80) }}</p>
                                </a>
                                <p class="font-sf opacity-60 text-sm">{{ $val->getFormattedDate() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-animate-on-scroll>

            <div class="flex flex-col lg:flex-row">
                <div class="hidden lg:block">
                    <div class="relative w-full lg:w-7/12">
                        <div class="lg:pl-10">
                            @include('partials.news-main', ['news' => $mainNews])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-animate-on-scroll animation="fade-in-up" class="text-center">
            <a class="font-inter text-xl block w-fit mx-auto py-2 px-4 my-4 bg-primary hover:bg-[#67A600] text-white rounded-3xl" href="{{ route('news', $locale) }}">{{ __("All news") }}</a>
        </x-animate-on-scroll>
    </div>
</div>
