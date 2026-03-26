@php($locale = app()->getLocale())

<x-animate-on-scroll animation="fade-in-right" class="w-full xl:max-w-6xl mx-auto my-16">
    <p class="font-inter text-4xl xl:text-5xl mb-5 text-center">{{ $opportunities_block?->{'title_' . $locale} }}</p>
    <div class="font-sf text-xl xl:text-2xl text-center opacity-80">{!! $opportunities_block?->{'content_' . $locale} !!}</div>
</x-animate-on-scroll>

<x-animate-on-scroll animation="fade-in-left" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    @foreach ($advantages as $advantage)
        <div class="bg-secondary flex space-x-2 rounded-3xl p-10">
            <div class="flex-1">
                <p class="font-inter font-semibold text-lg xl:text-2xl xl:leading-tight mb-6">{{ $advantage?->{'title_' . $locale} }}</p>
                <div class="font-interReg text-base xl:text-lg leading-none xl:leading-snug text-light">{!! $advantage?->{'text_' . $locale} !!}</div>
            </div>
            <div>
                <img class="w-20 shrink-0" src="{{ $advantage->getThumbnail() }}" alt="icon">
            </div>
        </div>
    @endforeach
</x-animate-on-scroll>
