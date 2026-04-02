@if (!empty($books))
    @php
        $defaultActive = 0;
        foreach ($books as $index => $book) {
            if (!empty($book['is_active'])) {
                $defaultActive = $index;
                break;
            }
        }
    @endphp
    <div class="book-accordion-wrapper w-full mb-8" x-data="{ activeBook: {{ $defaultActive }} }">
        <div
            class="bg-[#F0F2F5] p-6 md:p-10 rounded-[32px] w-full shadow-inner overflow-x-auto overflow-y-hidden [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <div class="flex flex-row gap-4 min-w-max items-stretch h-[320px] md:h-[368px]">
                @foreach ($books as $index => $book)
                    <div @click="activeBook = {{ $index }}"
                        class="book-item flex relative rounded-[10px] cursor-pointer transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] items-center shadow-[0_10px_40px_rgba(0,0,0,0.1)]"
                        :class="activeBook === {{ $index }} ? 'w-[85vw] md:w-[650px] !bg-[#FAFAFA] shadow-md border border-gray-100' : 'w-[70px] md:w-[85px] hover:-translate-y-3 bg-transparent text-transparent'"
                        style="-webkit-tap-highlight-color: transparent;">

                        <div class="absolute inset-0 w-full h-full transition-opacity duration-300 z-10"
                            :class="activeBook === {{ $index }} ? 'opacity-0 pointer-events-none' : 'opacity-100'">
                            @if(!empty($book['spine_image']))
                                <img src="{{ Storage::disk('public')->url($book['spine_image']) }}" alt="Spine"
                                    class="w-full !h-full object-contain md:object-cover object-center rounded-[20px] drop-shadow-md !m-0">
                            @endif
                        </div>

                        <div class="flex flex-row w-full h-full p-6 md:p-8 gap-6 md:gap-8 items-center transition-opacity duration-500 z-20"
                            :class="activeBook === {{ $index }} ? 'opacity-100' : 'opacity-0 pointer-events-none hidden'">

                            <div class="flex-shrink-0 w-[140px] md:w-[220px] h-full flex flex-col items-center justify-center">
                                @if(!empty($book['cover_image']))
                                    <img src="{{ Storage::disk('public')->url($book['cover_image']) }}" alt="Cover"
                                        class="max-w-full max-h-[100%] object-contain drop-shadow-lg border border-gray-300 !m-0">
                                @endif
                                @if(empty($book['cover_image']) && !empty($book['spine_image']))
                                    <img src="{{ Storage::disk('public')->url($book['spine_image']) }}" alt="Cover Fallback"
                                        class="max-w-full max-h-[100%] object-contain drop-shadow-xl !m-0">
                                @endif
                            </div>

                            <div class="flex flex-col flex-1 h-full py-2">
                                <h3 class="text-2xl md:text-3xl font-bold mb-1 md:mb-2 text-[#1a1a1a]">
                                    {{ $book['title'] ?? '' }}
                                </h3>

                                @if(!empty($book['subtitle']))
                                    <p class="text-sm md:text-md font-bold text-gray-800 mb-3 md:mb-4">{{ $book['subtitle'] }}</p>
                                @endif

                                @if(!empty($book['description']))
                                    <div class="prose prose-sm md:prose-base text-[#4a4a4a] text-sm md:text-base leading-relaxed mb-4 md:mb-6 overflow-y-auto pr-2"
                                        style="max-height: 180px;">
                                        {!! $book['description'] !!}
                                    </div>
                                @endif

                                @if(!empty($book['button_url']))
                                    <div class="mt-auto pt-2 text-right">
                                        <a href="{{ $book['button_url'] }}"
                                            class="inline-block hover:scale-105 transition-transform duration-200 text-sm"
                                            target="_blank">
                                            @if (isset($book['button_text']))
                                                <x-primary-button>
                                                    {{ $book['button_text'] }}
                                                </x-primary-button>
                                            @else
                                                <x-primary-button>
                                                    Подробнее
                                                </x-primary-button>
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(isset($footer))
                <div class="mt-6 pt-6">
                    {!! $footer !!}
                </div>
            @endif
        </div>
    </div>
@endif