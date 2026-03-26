<div class="youtube-video-container my-8 w-full">
    @if($youtubeId)
        <div class="relative w-full" style="aspect-ratio: 16 / 9;">
            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                class="absolute inset-0 w-full h-full rounded-xl shadow-lg" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    @else
        <div class="bg-gray-100 p-8 text-center rounded-xl border-2 border-dashed border-gray-300">
            <p class="text-gray-500">Некорректная ссылка на Youtube видео</p>
        </div>
    @endif
</div>