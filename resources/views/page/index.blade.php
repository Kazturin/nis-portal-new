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

                @if ($topMenu)
                    <div class="mb-10">
                        <x-page-top-menu :menu="$topMenu" :current_menu="$page->menu->id"></x-page-top-menu>
                    </div>
                @endif

                @if ($page->{'content_' . $locale} && $page->{'content_' . $locale} != "<p></p>")
                    <div class="max-w-7xl mx-auto mb-5 prose font-sf text-xl">
                        {!! $page->renderRichContent('content_' . $locale) !!}
                    </div>
                @endif

                @if(count($tabs) > 0)

                    <div x-data="{ tab: '{{ $tabs[0]['id'] ?? '' }}' }" class="tabs flex flex-col items-center">
                        <!-- Навигация -->
                        <nav
                            class="flex overflow-x-auto items-center p-1 space-x-1 rtl:space-x-reverse text-sm text-gray-600 bg-gray-500/5 rounded-xl dark:bg-gray-500/20">

                            @foreach($tabs as $t)
                                <button @click="tab = '{{ $t['id'] }}'"
                                    :class="tab === '{{ $t['id'] }}' 
                                                                                                                                                                ? 'text-yellow-600 shadow bg-white dark:text-white dark:bg-yellow-600' 
                                                                                                                                                                : 'hover:text-gray-800 focus:text-yellow-600 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:text-gray-400'"
                                    class="flex whitespace-nowrap items-center h-8 px-2 md:px-5 font-medium rounded-lg outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-inset"
                                    role="tab" type="button" :aria-selected="tab === '{{ $t['id'] }}'">
                                    {{ $t['title_' . app()->getLocale()] }}
                                </button>
                            @endforeach
                        </nav>

                        <!-- Контент -->
                        <div class="mt-4 w-full">
                            @foreach($tabs as $t)
                                <div x-show="tab === '{{ $t['id'] }}'" class="p-4 border rounded-lg">
                                    <p class="text-gray-600">{!! $t['content_' . app()->getLocale()] !!}</p>
                                </div>
                            @endforeach
                        </div>
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