<div class="iframe-container my-8 w-full">
    @if($url)
        @if($is_video ?? false)
            <div class="relative w-full overflow-hidden rounded-xl" style="padding-top: 56.25%;">
                <iframe class="absolute top-0 left-0 w-full h-full" src="{{ $url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        @else
            <div class="w-full overflow-hidden rounded-xl border border-gray-200">
                <iframe src="{{ $url }}" style="width: 100%; height: {{ $height }};" frameborder="0" allowfullscreen>
                </iframe>
            </div>
        @endif
    @else
        <div class="bg-gray-100 p-8 text-center rounded-xl border-2 border-dashed border-gray-300">
            <p class="text-gray-500">Некорректная ссылка для Iframe</p>
        </div>
    @endif
</div>