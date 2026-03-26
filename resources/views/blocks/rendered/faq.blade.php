<div class="container mx-auto">
        <div class="mb-10">
                <div class="p-5">
                    <div class="flex justify-center items-start my-2">
                        <div class="max-w-screen-lg">
                        <h1 x-data="{ shown: false }"
         x-intersect="shown = true"
         :class="{
             'opacity-0': !shown,
             'opacity-100 animate-fade-in-up': shown
         }" class="font-inter text-3xl xl:text-4xl mb-16 text-center">{{ __("Frequently asked questions") }}</h1>
                            <ul x-data="{ shown: false }"
         x-intersect="shown = true"
         :class="{
             'opacity-0': !shown,
             'opacity-100 animate-scale-in': shown
         }" class="flex flex-col rounded-2xl overflow-hidden">
                                
                                @forelse ($faq as $item)
                                <li class="my-1 bg-secondary px-5 py-8" x-data="accordion({{$item['id']}})">
                                    <h2 @click="handleClick()"
                                        class="flex flex-row justify-between items-center font-semibold cursor-pointer">
                                        <span class="flex-1 font-sf font-semibold text-xl">{{ $item['question'] }}</span>
                                        <svg :class="handleRotate()" class="shrink-0 g-white fill-current h-10 w-10 transform transition-transform duration-500 rounded-full p-1" viewBox="0 0 24 24" fill="none">
                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 8.29289C4.68342 7.90237 5.31658 7.90237 5.70711 8.29289L12 14.5858L18.2929 8.29289C18.6834 7.90237 19.3166 7.90237 19.7071 8.29289C20.0976 8.68342 20.0976 9.31658 19.7071 9.70711L12.7071 16.7071C12.3166 17.0976 11.6834 17.0976 11.2929 16.7071L4.29289 9.70711C3.90237 9.31658 3.90237 8.68342 4.29289 8.29289Z" fill="#000000"/>
                                        </svg>
                                    </h2>
                                    <div x-ref="tab" :style="handleToggle()"
                                        class="overflow-hidden max-h-0 duration-500 transition-all">
                                        <div class="text-sf text-lg p-3 tiptap-content">
                                            {!! $item['answer'] !!}
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <p class="text-sf text-lg">Пусто ...</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>