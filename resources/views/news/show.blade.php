<x-layout  :meta-title="$news->meta_title" :meta-description="$news->description">
    
    <div class="container mx-auto px-4 mb-20">
    <div class="mb-8">
            <x-page-banner banner="/img/page_banner.png" :text="__('News')" sub-text=""></x-page-banner>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8">
        <div class="mb-4 text-xl font-sf animate-fade-in-left">
                    <ul>
                        <li class="mb-2">
                            <a href="/"
                                class="px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl rounded-3xl">
                                {{__("Main")}}
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('news',app()->getLocale()) }}"
                                class="px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl rounded-3xl">
                                {{__("News")}}
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="lg:col-span-3 animate-fade-in-right">
                 <h1 class="font-inter text-4xl mb-10">{{ $news->{'title_' . app()->getLocale()} }}</h1>
                    <div class="my-4">
                        <img class="w-full rounded-3xl" src="{{ $news->getPhoto() }}" alt="news">
                    </div>
                <div class="mb-10">
                <p class="font-sf opacity-60 text-sm">{{ $news->getFormattedDate() }}</p>
                    <div class="tiptap-content font-sf text-xl">
                        {!! $news->{'content_'.app()->getLocale()} !!}
                    </div>
                </div>

                @if ($news->gallery)
                <div class="mb-10">
                <h1 class="text-3xl font-semibold uppercase">Фотогалерея</h1>
                <div class="bg-primary h-[3px] w-[74px] my-4"></div>

                 <div class="overflow-hidden slider">
                <div class="swiper-wrapper flex items-center">
                    @foreach ($news->gallery as $image)
                    <div class="swiper-slide p-2">
                        
                        <img class="block w-full rounded-lg object-cover" src="/storage/{{$image}}" alt="image-">
                        
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
                </div>
                
                @endif

               
                <div class="w-full flex pt-6">
                <div class="w-1/2">
                    @if($prev)
                        <a href="{{$prev->getUrl()}}"
                           class="block w-full h-full bg-white shadow hover:shadow-md text-left p-6">
                            <p class="text-lg text-gray-600 font-bold flex items-center">
                                <i class="fas fa-arrow-left pr-1"></i>
                                {!!'&laquo; '.__("Next")!!}
                            </p>
                            <p class="pt-2">{{\Illuminate\Support\Str::words($prev->{'title_'.app()->getLocale()}, 10)}}</p>
                        </a>
                    @endif
                </div>
                <div class="w-1/2">
                    @if($next)
                        <a href="{{$next->getUrl()}}"
                           class="block w-full h-full bg-white shadow hover:shadow-md text-right p-6">
                            <p class="text-lg text-gray-600 font-bold flex items-center justify-end">{!!__("Previous").' &raquo;'!!}
                                <i
                                    class="fas fa-arrow-right pl-1"></i></p>
                            <p class="pt-2">
                                {{\Illuminate\Support\Str::words($next->{'title_'.app()->getLocale()}, 10)}}
                            </p>
                        </a>
                    @endif
                </div>
            </div>
               
               
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset("/js/swiper-bundle.min.js") }}"></script>
        <script>
            var loop = '{{ ( $news->gallery && count($news->gallery) > 1) ? true : false }}';

            var swiper = new Swiper('.slider', {

                spaceBetween: 30,
                slidesPerView: 1,
                loop: loop,
                mousewheel: true,
                grabCursor: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

        </script>
    @endpush
</x-layout>