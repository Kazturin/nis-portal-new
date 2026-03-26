<div class="h-full transition-all duration-300 shadow-sm hover:shadow-md mx-auto"
    style="background-color: {{ $color ?? '#F0F2F5' }}; padding: {{ $padding ?? '40' }}px; border-radius: {{ $border_radius ?? '16' }}px; width: {{ isset($width) ? $width . '%' : 'fit-content' }};">
    @if(isset($title))
        <div class="mb-4">
            <span class="text-xl md:text-5xl font-inter-medium text-[#535B5E]">
                {{ $title }}
            </span>
        </div>
    @endif
    <div class="prose dark:prose-invert font-inter-medium text-xl">
        {!! $content !!}
    </div>
</div>