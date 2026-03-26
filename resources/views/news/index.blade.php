<x-layout>
    <div class="container mx-auto px-4 mb-20">
    <div class="mb-8">
            <x-page-banner banner="/img/news_banner.jpg" :text="__('News')" sub-text=""></x-page-banner>
        </div>
        <x-news-list :news="$news" :title="__('Latest news')"/>
    </div>
</x-layout>