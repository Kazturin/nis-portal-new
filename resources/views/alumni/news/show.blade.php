<x-layout  :meta-title="$news->meta_title" :meta-description="$news->description">
    
    <div class="container mx-auto px-4 mb-20">
    <div class="mb-8">
            <x-page-banner banner="/img/page_banner.png" :text="__('News')" sub-text=""></x-page-banner>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8">
        <div class="lg:col-span-1 animate-fade-in-left">
            <x-accordion-menu :menu="$accordion_menu"></x-accordion-menu>
            </div>
            <div class="lg:col-span-3 animate-fade-in-right">
                 <h1 class="font-inter text-4xl mb-10">{{ $news->{'title_' . app()->getLocale()} }}</h1>
                    <div class="my-4">
                        <img class="w-full rounded-3xl" src="{{ $news->getPhoto() }}" alt="news">
                    </div>
                <div class="mb-10">
                <p class="font-sf opacity-60 text-sm">{{ $news->getFormattedDate() }}</p>
                    <div class="tiptap-content">
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