<div>
    <ul>
        @foreach ($list as $item)
            <li class="mb-6">
                <div class="flex flex-col lg:flex-row rounded-xl items-center overflow-hidden bg-secondary">
                    @if ($item->image)
                        <img class="w-64 h-64 rounded-xl shrink-0 object-top object-cover" src="{{ $item->getImage() }}"
                            class="mr-6" alt="image">
                    @endif
                    <div class="flex flex-1 flex-col justify-center w-full p-11">
                        @if ($item->{'content_' . app()->getLocale()})
                            <a class="font-sfBold text-headlines cursor-pointer text-2xl mb-2"
                                href="{{ $item->getUrl() }}">{{ $item->{'title_' . app()->getLocale()} }}</a>
                        @else
                            <p class="font-sfBold text-headlines cursor-pointer text-2xl mb-2">
                                {{ $item->{'title_' . app()->getLocale()} }}
                            </p>
                        @endif
                        @if ($item->{'description_' . app()->getLocale()})
                            <div class="font-sf text-2xl text-light whitespace-pre-line tiptap-content mb-2">
                                {!! $item->{'description_' . app()->getLocale()} !!}
                            </div>
                        @endif

                        @if ($item->{'content_' . app()->getLocale()})
                            <div class="ml-auto">
                                <span class="text-2xl text-[#919191]">{{ $item->getFormattedDate() }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $list->links() }}
</div>