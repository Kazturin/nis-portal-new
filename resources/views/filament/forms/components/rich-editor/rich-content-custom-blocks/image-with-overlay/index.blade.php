<div class="relative my-16 mx-auto" style="width:{{ $max_width ?? '100%' }}">
    <img src="/storage/{{ $image }}" alt="mission_banner" @class([
        'hidden lg:block rounded-3xl',
        'ml-auto w-4/6' => $type == 1,
        'mr-auto w-7/12' => $type == 2,
    ])>
    <di @class([
        'block lg:absolute w-full shadow-md rounded-3xl h-min bottom-0 top-0 my-auto bg-secondary pl-10 lg:pl-16 pr-10 py-8',
        'lg:w-2/5 left-0' => $type == 1,
        'lg:w-1/2 right-0' => $type == 2,
    ])>
        <div class="font-sf text-xl my-4 mb-6"> {!! $description !!}</div>

        @if ($file)
            <button
                class="font-sfBold border border-rich-primary text-rich-primary px-4 py-2 rounded-full text-lg hover:bg-green-500 hover:text-white transition">
                Скачать презентацию
            </button>
        @endif
    </di>
</div>