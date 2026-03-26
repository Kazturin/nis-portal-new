@props([
    'news',
    'title'=>null,
])
<div class="mb-4 gap-8"
x-data="{ shown: false }"
         x-intersect="shown = true"
         :class="{
             'opacity-0': !shown,
             'opacity-100 animate-fade-in-up': shown
         }">
                <h1 class="font-inter text-4xl my-12">{{ $title }}</h1>
                <div class="mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-11">
                        @foreach ($news as $item)
                           <div class="flex flex-col">
                           <div class="max-h-72 rounded-3xl overflow-hidden">
                               <img class="w-full h-full object-cover" src="{{ $item->getPhoto() }}" alt="photo">
                           </div>
                           <div class="grow p-4">
                               <p class="mb-2 text-gray-500">{{ $item->getFormattedDate() }}</p>
                               <a href="{{ $item->getUrl() }}">
                                   <h1 class="font-sf font-semibold mb-2">{{ $item->{'title_'.app()->getLocale()} }}</h1>
                               </a>
                           </div>
                           </div>
                        @endforeach
                    </div>
                    <div class="my-4">
                        {{ $news->links() }}
                    </div>
                </div>
       
        </div>