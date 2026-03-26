<x-layout :metaTitle="$page->{'title_'.app()->getLocale()}">
    <div class="container mx-auto px-4 mb-20">
        <div class="mb-8">
            <x-page-banner banner="{{ $page->menu->getBanner() }}" :text="$page->menu->parent ? $page->menu->parent->{'title_'.app()->getLocale()} : $page->menu->{'title_'.app()->getLocale()}" sub-text=""></x-page-banner>
        </div>  

        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8">
            <div class="lg:col-span-1 animate-fade-in-left">
                <img src="/img/chapter_bg2.webp" alt="" class="w-full rounded-xl">
            </div>
            <div class="lg:col-span-3 animate-fade-in-right">
                 @if ($page->banner?->{'banner_'.app()->getLocale()})
                    <img src="/storage/{{ $page->banner?->{'banner_'.app()->getLocale()} }}" alt="banner" class="w-full max-h-[300px] object-cover rounded object-center mb-8">
                    @endif
                <h1 class="font-inter text-xl md:text-3xl mb-10">{{ $page->{'title_'.app()->getLocale()} }}</h1>
                
               
                <div>
                    <div class="content tiptap-content text-xl">
                        {!! $page->{'content_'.app()->getLocale()} !!}
                    </div>
                </div>


            </div>
        </div>
    </div>
</x-layout>

