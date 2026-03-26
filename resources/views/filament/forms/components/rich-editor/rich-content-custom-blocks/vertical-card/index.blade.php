<div class="card h-full bg-[#F0F2F5] rounded-[32px] p-8 flex flex-col justify-between mb-6">
    <div>
        @if (isset($image) && $image)
            <div class="flex justify-center">
                <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $title ?? 'Card image' }}"
                    class="max-h-40 w-auto object-contain !m-0">
            </div>
        @endif

        @if(isset($title) && $title)
            <h3 class="text-lg font-inter-regular font-medium mb-4">{{ $title }}</h3>
        @endif

        <div class="prose max-w-none text-base text-black/80 text-left">
            {!! $description !!}
        </div>
    </div>

    @if (isset($button_url) && isset($button_text))
        <div class="flex justify-end">
            <a href="{{ $button_url }}" class="hover:scale-105 transition-transform">
                <x-primary-button class="text-lg py-1 px-8">
                    {{ $button_text }}
                </x-primary-button>
            </a>
        </div>
    @endif
</div>