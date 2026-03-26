<div class="not-prose w-full bg-[#F1F3F5] rounded-[2rem] p-6 flex flex-col sm:flex-row items-center gap-6 md:gap-10">
    <div class="w-24 h-24 min-w-[6rem] rounded-2xl flex items-center justify-center text-4xl font-extrabold text-gray-900 shadow-sm"
        style="background-color: {{ $badge_color ?? '#BEE98F' }};">
        {{ $badge_text }}
    </div>

    <div class="text-xl md:text-2xl font-inter text-slate-800 leading-tight text-center sm:text-left">
        @php
            // Simple logic to bold CEFR or other parts if needed
            $formattedText = str_replace('CEFR', '<strong>CEFR</strong>', $description);
        @endphp
        {!! $formattedText !!}
    </div>
</div>