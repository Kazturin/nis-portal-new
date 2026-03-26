@props(['files'])

<div>
    <div>
        @foreach ($files as $file)
            <div class="flex border-t py-6">
                <div class="shrink-0">
                    <img class="w-36" src="{{ $file->getThumbnail() }}" alt="docs">
                </div>

                <div class="p-8 flex-1">
                    <p class="font-sf font-medium text-2xl mb-8">
                        {{ $file->{'title_' . app()->getLocale()} }}
                    </p>

                    @php
                        $link = $file->{'link_' . app()->getLocale()};
                        $filesLocale = $file->{'files_' . app()->getLocale()};
                        $hasMultipleFiles = is_array($filesLocale) && count($filesLocale) > 1;
                        $firstFile = $filesLocale[0] ?? null;
                    @endphp

                    @if ($link)
                        <div class="font-sf text-xl my-4">
                            <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px]" 
                               href="{{ $link }}" 
                               target="_blank">
                                {{ __("View online") }}
                            </a>
                        </div>
                    @elseif ($filesLocale)
                        <div class="font-sf text-xl my-4">
                            @if ($hasMultipleFiles)
                                <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px]" 
                                   href="{{ route('files', ['locale' => app()->getLocale(), 'pageFile' => $file]) }}">
                                    {{ __("More") }}
                                </a>
                            @else
                                <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px] mr-2" 
                                   href="/storage/{{ $firstFile }}" 
                                   target="_blank">
                                    {{ __("View online") }}
                                </a>
                                <a class="bg-secondary rounded-3xl hover:bg-primary hover:text-white px-6 pt-[13px] pb-[15px]" 
                                   href="/storage/{{ $firstFile }}" 
                                   download>
                                    {{ __("Download") }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div>
        {{ $files->links() }}
    </div>
</div>