<div class="curriculum-card not-prose mb-4 w-full h-full flex flex-col items-center">
    @if(!empty($top_label))
        <div class="mb-4 text-center">
            <span class="text-sm md:text-base font-bold text-[#7E8487] uppercase tracking-[0.1em] font-inter">
                {{ $top_label }}
            </span>
        </div>
    @endif

    {{-- Главный контейнер карточки --}}
    <div class="relative w-full rounded-[24px] p-6 md:p-8 pt-8 transition-all duration-300 shadow-sm hover:shadow-md h-full min-h-[300px] mt-3"
        style="background-color: {{ $background_color ?? '#BEE98F' }};">

        {{-- Иконка с точными размерами из Figma (46x46) и рамкой 8px --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center">

            <svg width="48" height="45" viewBox="0 0 48 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M14.8867 35.5C18.7357 42.1666 28.358 42.1666 32.207 35.5L41.7334 19C45.5824 12.3334 40.7712 4.00006 33.0732 4H14.0205C6.32256 4.00007 1.51136 12.3334 5.36035 19L14.8867 35.5Z"
                    fill="{{ $background_color ?? '#BEE98F' }}" stroke="white" stroke-width="8" />
            </svg>
        </div>

        {{-- Content --}}
        <div class="rich-content-wrapper font-inter space-y-6 !text-base">
            {!! $content !!}
        </div>
    </div>
</div>