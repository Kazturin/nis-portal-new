@php
    $imageStyle = $image_style ?? 'contain';
@endphp

<div class="card relative bg-[#F0F2F5] rounded-[32px] mb-8 overflow-hidden min-h-[300px] flex items-center">
    @if (isset($image) && $image && $imageStyle === 'cover')
        <div class="absolute flex justify-end right-0 top-0 h-full w-full z-0">
            <div class="absolute inset-0 short-gradient"></div>
            <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $title ?? 'Banner' }}"
                class="!h-full  md:w-3/4 object-cover object-right !m-0">

        </div>
    @endif

    <div class="relative z-10 p-8 md:p-10 w-full">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 h-full">
            <div class="flex-1 text-left space-y-6 {{ $imageStyle === 'cover' ? 'md:max-w-[60%]' : '' }}">
                @if(isset($title) && $title)
                    <h3 class="text-lg !font-inter-medium mb-4">{{ $title }}</h3>
                @endif

                <div class="prose max-w-none text-black/80 text-left">
                    {!! $description !!}
                </div>

                @if (isset($button_url) && isset($button_text))
                    <div class="pt-6">
                        <a href="{{ $button_url }}" class="inline-block hover:scale-105 transition-transform duration-200">
                            <x-primary-button>
                                {{ $button_text }}
                            </x-primary-button>
                        </a>
                    </div>
                @endif
            </div>

            @if (isset($image) && $image && $imageStyle === 'contain')
                <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center md:justify-end">
                    <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $title ?? 'Card image' }}"
                        class="max-h-64 h-auto w-auto object-contain">
                </div>
            @endif
        </div>
    </div>
</div>