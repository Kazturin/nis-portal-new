@php($locale = app()->getLocale())

<div class="container mx-auto my-6 hero-section">
    <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-2">
        <div class="mt-6">
            <h1 class="animate-fade-in-left transition-all text-4xl md:text-[4rem] leading-none font-inter mb-12">{!! __('site.app_title_display') !!}</h1>
            <div class="animate-fade-in-left transition-all mb-4 text-2xl font-sf max-w-[574px] opacity-80">{!! $mission->{'content_' . $locale} !!}</div>
        </div>
        <div class="animate-fade-in-right ml-0 mr-0 xl:ml-[-100px] xl:mr-[50px]">
            {!! $mainBanner ? $mainBanner->{'content_' . $locale} : '' !!}
            <!-- <img class="w-full" src="/img/banner_header.webp" alt="banner"> -->
        </div>
    </div>
</div>
