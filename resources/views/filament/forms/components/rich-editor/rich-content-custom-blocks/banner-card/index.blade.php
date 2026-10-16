<div class="relative flex items-center gap-4 p-6 rounded-xl my-4 banner-card"
    style="--banner-title-color: {{ $title_color ?? '#245522' }}; --banner-text-color: {{ $text_color ?? '#31572E' }};">
    @if (!empty($background_image))
        <img src="{{ Storage::disk('public')->url($background_image) }}" alt="" aria-hidden="true"
            class="banner-card__background">
    @endif

    @if (!empty($icon))
        <img src="{{ Storage::disk('public')->url($icon) }}" alt="" class="banner-card__icon !rounded-full">
    @endif

    <div class="banner-card__content">
        @if (!empty($title))
            <h2 class="banner-card__title text-xl xl:text-[27px] font-inter font-semibold mb-1 leading-none">{{ $title }}</h2>
        @endif

        @if (!empty($description))
            <div class="text-base banner-card__description">{!! $description !!}</div>
        @endif
    </div>
    @if (!empty($url))
        <a href="{{ $url }}"
            class="z-10 flex h-12 w-12 shrink-0 items-center justify-center self-end rounded-full bg-gray-100 text-gray-700 sm:self-center"
            aria-label="Banner Card Link">
            <span class="absolute inset-0 z-10" aria-hidden="true"></span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14m-6-6 6 6-6 6" />
            </svg>
        </a>
    @endif
</div>
