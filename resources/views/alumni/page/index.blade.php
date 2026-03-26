
<x-layout>
    <div class="container mx-auto px-4 mb-20">

        <div>
            <x-page-banner banner="{{ $page->menu->getBanner() }}" :text="$page->menu->{'title_'.app()->getLocale()}" sub-text=""></x-page-banner>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 my-8 gap-8">
            <div class="lg:col-span-1 animate-fade-in-left">
            <x-accordion-menu :menu="$accordion_menu" :pageParentMenu="$page->menu->parent_id" :pageMenu="$page->menu->id"></x-accordion-menu>
            </div>
            <div class="lg:col-span-3 animate-fade-in-right alumni">
                <h1 class="font-inter text-3xl animate-fade-in-up">{{ $page->{'title_'.app()->getLocale()} }}</h1>
                <div>
                    <br>
                   
                    <div class="tiptap-content text-xl">
                    {!! tiptap_converter()->asHTML($page->{'content_'.app()->getLocale()}) !!}
                    </div>

                    @if ($lists->isNotEmpty())
                    <hr>
                    <x-page-lists :view_type="$page->lists_view_type?->value" :lists="$lists" />
                    @endif

                    @if ($gallery)
                    <x-gallery :gallery="$gallery"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>