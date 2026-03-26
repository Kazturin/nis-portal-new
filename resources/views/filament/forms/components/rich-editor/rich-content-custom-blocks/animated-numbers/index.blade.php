<div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
    @foreach ($cards as $card)
        <div class="relative rounded-2xl overflow-hidden text-center" x-data="{ 
                            visible: false, 
                            count: 0, 
                            formatted: '0', 
                            startCount() {
                                let i = 0; 
                                let end = {{ $card['number'] ?? 0 }}; 
                                let step = end / 100; 
                                let interval = setInterval(() => { 
                                    i += step; 
                                    if (i >= end) { 
                                        i = end; 
                                        clearInterval(interval); 
                                    } 
                                    this.count = Math.floor(i); 
                                    this.formatted = this.count.toLocaleString('ru-RU'); 
                                }, 20); 
                            } 
                        }" :class="{
                             'opacity-0': !visible,
                             'opacity-100 animate-fade-in-down': visible
                         }" x-intersect.once="visible = true; startCount()">
            <img style="margin:0" class="w-full h-full"
                src="{{ isset($bg_image) ? Storage::url($card['bg_image']) : '/img/card-bg.png' }}" alt="card">
            <div class="absolute inset-0 text-white px-6 py-5">
                <div class="flex flex-col items-center justify-center h-full">
                    <div class="font-sf text-2xl md:text-5xl">
                        {!! nl2br(e($card["text"])) !!}
                    </div>
                    <div class="mt-2">
                        @if ($card["number"])
                            <span x-show="visible" x-text="formatted"
                                class="text-2xl md:text-3xl xl:text-4xl font-bold mr-4"></span>
                        @endif
                        <span class="font-inter text-2xl">{{ $card["title"] }}</span>
                    </div>

                </div>

            </div>
        </div>


    @endforeach
</div>