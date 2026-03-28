<x-layout  :meta-title="$news->meta_title ?: $news->{'title_' . app()->getLocale()}" :meta-description="$news->description" :meta-image="$news->getPhoto()">
    
    <div class="container mx-auto px-4 mb-20">
    <div class="mb-8">
            <x-page-banner banner="/img/page_banner.png" :text="__('News')" sub-text=""></x-page-banner>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8 news">
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

                    <div class="flex items-center gap-4 py-8 border-t border-gray-100 mt-10">
                        <span class="font-sf opacity-60 text-lg uppercase tracking-wider">{{ __('Share') }}:</span>
                        <div class="flex gap-3">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               title="Facebook"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-110 transition-transform shadow-sm">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            
                            <!-- Telegram -->
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->{'title_' . app()->getLocale()}) }}" 
                               target="_blank" 
                               title="Telegram"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-[#24A1DE] text-white hover:scale-110 transition-transform shadow-sm">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M11.944 0C5.346 0 0 5.346 0 11.944c0 6.598 5.346 11.944 11.944 11.944s11.944-5.346 11.944-11.944C23.889 5.346 18.542 0 11.944 0zm5.811 8.24c-.161 1.7-.852 5.758-1.205 7.641-.149.799-.441 1.066-.726 1.092-.619.056-1.089-.411-1.689-.806-.94-.617-1.469-.999-2.383-1.599-1.054-.693-.372-1.074.231-1.698.157-.164 2.897-2.657 2.95-2.885.006-.028.013-.135-.05-.19-.063-.056-.156-.037-.221-.022-.093.022-1.579 1.002-4.455 2.946-.421.289-.802.432-1.143.425-.375-.007-1.095-.212-1.63-.385-.657-.212-1.178-.323-1.133-.683.024-.188.283-.379.775-.572 3.033-1.32 5.056-2.193 6.066-2.617 2.898-1.214 3.499-1.425 3.892-1.431.087-.001.28.021.405.122.106.086.136.202.146.287.01.085.013.253-.002.321z"/></svg>
                            </a>
                            
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->{'title_' . app()->getLocale()} . ' ' . url()->current()) }}" 
                               target="_blank" 
                               title="WhatsApp"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-[#25D366] text-white hover:scale-110 transition-transform shadow-sm">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.559.925 3.678 1.417 4.939 1.417 5.421 0 9.833-4.412 9.833-9.834 0-5.421-4.412-9.833-9.834-9.833-5.422 0-9.834 4.412-9.834 9.834 0 2.125.675 4.134 1.944 5.79l-1.056 3.856 3.991-1.047zm10.749-6.346c-.285-.143-1.688-.833-1.944-.925-.257-.091-.43-.143-.615.143-.185.286-.713.925-.873 1.114-.16.188-.32.214-.605.071-.285-.143-1.203-.444-2.291-1.415-.847-.756-1.419-1.69-1.585-1.975-.167-.285-.018-.439.124-.581.128-.127.285-.343.428-.514.143-.171.185-.285.285-.471.1-.186.05-.343-.028-.486-.079-.143-.615-1.486-.841-2.029-.226-.543-.451-.457-.615-.457s-.328-.029-.557-.029c-.228 0-.6-.086-.913.257-.314.343-1.199 1.171-1.199 2.857 0 1.686 1.228 3.314 1.399 3.543.171.229 2.417 3.691 5.857 5.172.82.354 1.458.565 1.957.721.82.261 1.567.225 2.156.137.656-.098 1.688-.691 1.928-1.353.242-.662.242-1.228.171-1.353-.07-.128-.256-.199-.541-.342z"/></svg>
                            </a>
                        </div>
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
                <div class="swiper-pagination pagination shadow-md m-auto !bottom-10"></div>
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
                pagination: {
                el: '.pagination',
                clickable: true,
            },
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