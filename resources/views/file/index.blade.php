<x-layout>
   
    <div class="container mx-auto my-8 px-4">
            <div>
                 <x-page-banner banner="{{ $page->menu->getBanner() }}" :text="$page->menu->parent?->{'title_'.app()->getLocale()}" sub-text=""></x-page-banner>
            </div>
        <div class="flex items-center flex-wrap my-8">
            <ul class="flex items-center text-lg">
                <li class="inline-flex items-center">
                    <a href="/" class="text-gray-600 hover:text-primary">
                        <svg class="w-5 h-auto fill-current mx-2 text-gray-400" viewBox="0 0 24 24" fill="#000000">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z" />
                        </svg>
                    </a>

                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
             
                <li class="inline-flex items-center">
                    <a href="{{route('page',['locale'=>app()->getLocale(),'page'=>$page])}}" class="text-gray-600 hover:text-primary">
                       {{ $page->{'title_'.app()->getLocale()} }}
                    </a>
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
               
                <li class="inline-flex items-center">
                    {{ $pageFile->{'title_'.app()->getLocale()} }}
                </li>
            </ul>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8">
            <div class="lg:col-span-1">
                <x-accordion-menu :menu="$accordion_menu" :pageParentMenu="$page->menu->parent_id" :pageMenu="$page->menu->id"></x-accordion-menu>
            </div>
            <div class="lg:col-span-3">
                <h1 class="font-inter text-3xl mb-10">{{ $pageFile->{'title_'.app()->getLocale()} }}</h1>
               
                <div class="my-10">
                @foreach ($pageFile->{'files_'.app()->getLocale()} as $file)
    <div class="flex flex-col md:flex-row border-t py-6">
        <img src="/img/docs.jpg" alt="docs">
        <div class="p-8">
            <p class="font-sf font-medium text-2xl mb-8">{{  __('site.part',['part'=>($loop->index+1)]) }}</p>
            <div class="font-sf text-xl my-4">
                <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px] mr-2" href="{{ '/storage/'.$file }}" target="_blank">{{ __("View online") }}</a>
                <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px]" href="{{ '/storage/'.$file }}" download="">{{ __("Download") }}</a>
            </div>
        </div>
    </div>
    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</x-layout>