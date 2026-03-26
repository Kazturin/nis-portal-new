<div class="h-full rounded-2xl overflow-hidden shadow-lg border">
    <div class="">
        <img style="border-radius: 0px;" class="block rounded-none w-full object-contain h-full" src="/storage/{{ $image }}">
    </div>
    <div class="bg-white p-5 h-full">
        <div class="flex overflow-hidden">
            @if (isset($icon))
            <div class="shrink-0 w-8 mr-2">
                <img class="w-full object-cover rounded-full mr-4" src="/storage/{{ $icon }}" alt="icon">
            </div>
            @endif
            <div class="mb-2 text-xl">{!! $text !!}</div>
        </div>
    </div>
</div>