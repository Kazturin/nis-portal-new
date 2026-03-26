<div class="grid grid-cols-1 md:grid-cols-2 gap-10 my-4">
    <div>
        <img class="block rounded-[60px] w-full object-cover" src="/storage/{{ $image }}">
    </div>
    <div>
        <h1 class="font-nunitoExtraBold text-3xl lg:text-5xl lg:leading-[130%] mb-8">{{ $title }}</h1>
        <ul class="mb-10">
            @foreach ($items as $item)
            <li class="flex items-center mb-6">
            <span data-state="checked" class="bg-primary text-white rounded-full p-1.5 mr-4" style="pointer-events: none;"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon size-3.5 stroke-[3]"><path d="M20 6 9 17l-5-5"></path></svg></span>    
            <span class="text-xl lg:text-2xl font-sf text-gray-700 ">{{ $item['text'] }}</span>
            </li>
            @endforeach
        </ul>
        @if ($link)
            <a href="{{ $link }}"
            target="_blank"
                class="font-sf border border-rich-primary bg-primary text-white px-8 py-2 rounded-full text-lg hover:bg-white hover:text-primary transition">
                {{ $link_text }}
</a>
        @endif  
    </div>
</div>