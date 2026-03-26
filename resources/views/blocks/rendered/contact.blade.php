<div id="contact" class="my-10 max-w-5xl mx-auto">
    <h1 class="font-inter text-2xl mb-6">{{ $title }}</h1>

    <div class="flex flex-col md:flex-row space-x-0 md:space-x-4">
        <div class="w-full md:w-3/5">
            @foreach ($items as $item)
            <div class="flex space-x-4 mb-4">
              <div class="shrink-0 w-20">
                <img src="/storage/{{ $item['icon'] }}" class="w-full m-0" alt="">
            </div>
            <div class="flex-1">
               {!! $item['text'] !!}
            </div>
            </div>
            @endforeach
        </div>
        <div class="w-full md:w-2/5">
<div class="w-full">
            {!! $address !!}
        </div>
        </div>
        
    </div>
</div>