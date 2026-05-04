<div class="iframe-container my-8 w-full">
    @if($url)
        <div class="w-full overflow-hidden rounded-xl border border-gray-200">
            <iframe src="{{ $url }}" style="width: 100%; height: {{ $height }};" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    @else
        <div class="bg-gray-100 p-8 text-center rounded-xl border-2 border-dashed border-gray-300">
            <p class="text-gray-500">Некорректная ссылка для Iframe</p>
        </div>
    @endif
</div>