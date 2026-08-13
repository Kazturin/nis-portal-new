<x-layout :metaTitle="$metaTitle">
    <div class="container mx-auto px-4 mb-20">
        <div class="mb-8">
            <x-page-banner banner="{{ $page->menu->getBanner() }}" :text="$page->menu->parent ? $page->menu->parent->{'title_' . app()->getLocale()} : $page->menu->{'title_' . app()->getLocale()}"
                sub-text=""></x-page-banner>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 mb-4 gap-8">
            <div class="lg:col-span-1 animate-fade-in-left">
                <x-accordion-menu :menu="$accordion_menu" :pageParentMenu="$page->menu->parent_id"
                    :pageMenu="$page->menu->id" :rootMenu="$page->menu->parent?->parent_id"></x-accordion-menu>
            </div>
            <div class="lg:col-span-3 animate-fade-in-right">
                @if ($page->banner?->{'banner_' . app()->getLocale()})
                    <img src="/storage/{{ $page->banner?->{'banner_' . app()->getLocale()} }}" alt="banner"
                        class="w-full max-h-[300px] object-cover rounded object-center mb-8">
                @endif
                <h1 class="font-inter text-xl md:text-3xl mb-10">{{ $page->{'title_' . app()->getLocale()} }}</h1>

                @if (!empty($page->{'content_' . $locale}))
                    <div class="max-w-7xl mx-auto mb-5 prose font-sf text-xl">
                        {!! $page->renderRichContent('content_' . $locale) !!}
                    </div>
                @endif


                <div class="my-4">
                    @if(count($files))
                        <div class="my-4">
                            <x-page-files :files="$files" />
                        </div>
                    @endif
                    @if(count($list) > 0)
                        <x-page-lists :view_type="$page->lists_view_type?->value" :list="$list" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>