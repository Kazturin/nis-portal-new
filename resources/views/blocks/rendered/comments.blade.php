<div class="my-20">
      <h1 class="font-inter text-4xl mb-20 text-center">{{ $title }}</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-10 gap-y-20">
        @foreach ($items as $item)
        <div class="block rounded-2xl shadow-2xl border p-4 md:p-10">
            <img class="w-48 h-48 rounded-full object-cover border-rich-primary border-4 mx-auto mb-10 -mt-20" src="/storage/{{ $item['icon'] }}" alt="">
            <p class="font-sf text-medium text-2xl text-center">{{ $item['text'] }}</p>
            <p class="font-sfBold text-rich-primary text-center text-xl mt-10">{{ $item['author'] }}</p>
        </div>
        @endforeach
      </div>
    </div>